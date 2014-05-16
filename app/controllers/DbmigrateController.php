<?php

/* * **
 * 
 * This script converts an existing MySQL database to migrations in Laravel 4.
 * 
 * 1. Place this file inside app/controllers/
 * 
 * 2. In this file, edit the index() method to customize this script to your needs.
 *      - inside $migrate->ignore(), you pass in an array of table 
 *        names that you want to ignore. Note that Laravel's 'migrations'
 *        table is ignored by default.
 *      - inside $migrate->convert(), pass in your database name.
 * 
 * 3. Add to your app/routes.php:
 * 
 *   Route::get('dbmigrate', 'DbmigrateController@index');
 * 
 * 4. run this script by going to http://your-site.com/dbmigrate, the resulting
 *    migration file will be generated in app/database/migrations/
 * 
 * @author Lee Zhen Yong <bruceoutdoors@gmail.com>
 * credits to @Christopher Pitt and @michaeljcalkins, whom this gist is forked off
 * 
 * ** */

class DbmigrateController extends BaseController
{

    public function index()
    {
        $migrate = new SqlMigrations;
        // $migrate->ignore(['some_table_name', 'another_table_name']);
        $migrate->convert('linguistics_dev');
        $migrate->write();
    }

}

class SqlMigrations
{

    private static $ignore = array('migrations');
    private static $database = "";
    private static $migrations = false;
    private static $schema = array();
    private static $selects = array('column_name as Field', 'column_type as Type', 'is_nullable as Null', 'column_key as Key', 'column_default as Default', 'extra as Extra', 'data_type as Data_Type');
    private static $instance;
    private static $up = "";
    private static $down = "";

    private static function getTables()
    {
        return DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema="' . self::$database . '"');
    }

    private static function getTableDescribes($table)
    {
        return DB::table('information_schema.columns')
                ->where('table_schema', '=', self::$database)
                ->where('table_name', '=', $table)
                ->get(self::$selects);
    }

    private static function getForeignTables()
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('CONSTRAINT_SCHEMA', '=', self::$database)
                ->where('REFERENCED_TABLE_SCHEMA', '=', self::$database)
                ->select('TABLE_NAME')->distinct()
                ->get();
    }

    private static function getForeigns($table)
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('CONSTRAINT_SCHEMA', '=', self::$database)
                ->where('REFERENCED_TABLE_SCHEMA', '=', self::$database)
                ->where('TABLE_NAME', '=', $table)
                ->select('COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
                ->get();
    }

    private static function compileSchema()
    {
        $upSchema = "";
        $downSchema = "";
        $newSchema = "";
        foreach (self::$schema as $name => $values) {
            if (in_array($name, self::$ignore)) {
                continue;
            }
            $upSchema .= "
//
// NOTE -- {$name}
// --------------------------------------------------
 
{$values['up']}";
            $downSchema .= "
{$values['down']}";
        }

        $schema = "<?php
 
//
// NOTE Migration Created: " . date("Y-m-d H:i:s") . "
// --------------------------------------------------
 
class Create" . str_replace('_', '', Str::title(self::$database)) . "Database {
//
// NOTE - Make changes to the database.
// --------------------------------------------------
 
public function up()
{
" . $upSchema . "
" . self::$up . "
}
 
//
// NOTE - Revert the changes to the database.
// --------------------------------------------------
 
public function down()
{
" . $downSchema . "
" . self::$down . "
}
}";

        return $schema;
    }

    public function up($up)
    {
        self::$up = $up;
        return self::$instance;
    }

    public function down($down)
    {
        self::$down = $down;
        return self::$instance;
    }

    public function ignore($tables)
    {
        self::$ignore = array_merge($tables, self::$ignore);
        return self::$instance;
    }

    public function migrations()
    {
        self::$migrations = true;
        return self::$instance;
    }

    public function write()
    {
        $schema = self::compileSchema();
        $filename = date('Y_m_d_His') . "_create_" . self::$database . "_database.php";

        file_put_contents("../app/database/migrations/{$filename}", $schema);
    }

    public function get()
    {
        return self::compileSchema();
    }

    public function convert($database)
    {
        self::$instance = new self();
        self::$database = $database;
        $table_headers = array('Field', 'Type', 'Null', 'Key', 'Default', 'Extra');
        $tables = self::getTables();
        foreach ($tables as $key => $value) {
            if (in_array($value->table_name, self::$ignore)) {
                continue;
            }

            $down = "Schema::drop('{$value->table_name}');";
            $up = "Schema::create('{$value->table_name}', function($" . "table) {\n";
            $tableDescribes = self::getTableDescribes($value->table_name);
            foreach ($tableDescribes as $values) {
                $method = "";
                $para = strpos($values->Type, '(');
                $type = $para > -1 ? substr($values->Type, 0, $para) : $values->Type;
                $numbers = "";
                $nullable = $values->Null == "NO" ? "" : "->nullable()";
                $default = empty($values->Default) ? "" : "->default(\"{$values->Default}\")";
                $unsigned = strpos($values->Type, "unsigned") === false ? '' : '->unsigned()';
                $unique = $values->Key == 'UNI' ? "->unique()" : "";
                switch ($type) {
                    case 'int' :
                        $method = 'unsignedInteger';
                        break;
                    case 'char' :
                    case 'varchar' :
                        $para = strpos($values->Type, '(');
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'string';
                        break;
                    case 'float' :
                        $method = 'float';
                        break;
                    case 'decimal' :
                        $para = strpos($values->Type, '(');
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'decimal';
                        break;
                    case 'tinyint' :
                        $method = 'boolean';
                        break;
                    case 'date':
                        $method = 'date';
                        break;
                    case 'timestamp' :
                        $method = 'timestamp';
                        break;
                    case 'datetime' :
                        $method = 'dateTime';
                        break;
                    case 'mediumtext' :
                        $method = 'mediumtext';
                        break;
                    case 'text' :
                        $method = 'text';
                        break;
                }
                if ($values->Key == 'PRI') {
                    $method = 'increments';
                }
                $up .= " $" . "table->{$method}('{$values->Field}'{$numbers}){$nullable}{$default}{$unsigned}{$unique};\n";
            }

            $up .= " });\n\n";
            self::$schema[$value->table_name] = array(
                'up' => $up,
                'down' => $down
            );
        }

        // add foreign constraints, if any
        $tableForeigns = self::getForeignTables();
        if (sizeof($tableForeigns) !== 0) {
            foreach ($tableForeigns as $key => $value) {
                $up = "Schema::table('{$value->TABLE_NAME}', function($" . "table) {\n";
                $foreign = self::getForeigns($value->TABLE_NAME);
                foreach ($foreign as $k => $v) {
                    $up .= " $" . "table->foreign('{$v->COLUMN_NAME}')->references('{$v->REFERENCED_COLUMN_NAME}')->on('{$v->REFERENCED_TABLE_NAME}');\n";
                }
                $up .= " });\n\n";
                self::$schema[$value->TABLE_NAME . '_foreign'] = array(
                    'up' => $up,
                    'down' => $down
                );
            }
        }

        return self::$instance;
    }

}
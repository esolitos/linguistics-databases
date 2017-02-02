<?php


Form::macro('form_checkbox', function($name, $value, $label, $checked = null, $options = array())
{
    $id = $name;
    if ( empty($options['id']) ) {
        $options['id'] = $name;
    } else {
        $id = $options['id'];
    }

    return '<label for="'.$id.'">'.Form::checkbox($name, $value, $checked, $options).' '.$label.'</label>';
});



Form::macro('field_error', function($field, $errors){
    if($errors->has($field)){
        $msg = $errors->first($field);
        return "<span class='error'>$msg</span>";
    }
    return '';
});

Form::macro('label_item_error', function($type, $name, $label, $value, $errors, $options = [] ){
    $error_class = ($errors->has($name)) ? 'error' : '';
    $id = (empty($options['id'])) ? $name : $options['id'];
    $options['id'] = $id;

    $html = "<label class='{$error_class}' for='{$id}'>";

    switch ($type) {
        case 'raw':
            $html .= $label;
            $html .= $value;
            break;

        case 'text':
            $html .= $label;
            $html .= Form::text($name, $value, $options);
            break;

        case 'checkbox':
            $checked = (isset($options['checked']) && $options['checked'] == TRUE);

            $html .= Form::checkbox($name, $value, $checked, $options);
            $html .= " {$label}";
            break;

        default:
            $options['type'] = $type;
            $html .= $label;
            $html .= Form::text($name, $value, $options);
            break;
    }

    if ($error_class != '') {
        $html .= "<small class='error'>{$errors->first($name)}</small>";
    }

    return $html.'</label>';
});

Form::macro('label_select_error', function($name, $label, $value_list, $errors, $selected = null, $options = [] ){
    if (empty($options['id'])) {
        $options['id'] = $name;
    }

    return Form::label_item_error('raw', $name, $label, Form::select($name, $value_list, $selected, $options), $errors);
});
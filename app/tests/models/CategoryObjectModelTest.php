<?php

class CategoryObjectModelTest extends TestCase
{
  /*
  $table->enum('type', array('IND', 'DIR'));
  $table->enum('form', array('NP', 'PR', 'CL'));
  $table->enum('declination', array('ACC', 'DAT', 'GEN', 'INS'));
  $table->boolean('has_preposition');
  */
  
  public function testCategoryObjectManage()
  {
    $cat_object = new CategoryObject();
    
    $cat_object->type = 'IND';
    $cat_object->form = 'NP';
    $cat_object->has_preposition = TRUE;
    
    $this->assertFalse( $cat_object->save() );

    $errors = $cat_object->errors()->all();
    $this->assertCount(1, $errors);
    $this->assertEquals($errors[0], "The declination field is required.");

    $cat_object->declination = 'ACC';
    $this->assertTrue( $cat_object->save() );
    
    $id = $cat_object->id;

    $new_object = CategoryObject::find($id);
    
    $this->assertEquals('IND', $new_object->type);
  }

  
  
  public function testDuplicateCategoryObject()
  {    
    // Single Insert
    $cat_object = new CategoryObject();
    $cat_object->type = 'IND';
    $cat_object->form = 'NP';
    $cat_object->declination = 'ACC';
    $this->assertTrue($cat_object->save());
    // Another Insert
    $cat_object = new CategoryObject();
    $cat_object->type = 'DIR';
    $cat_object->form = 'PR';
    $cat_object->declination = 'ACC';
    $cat_object->has_preposition = TRUE;
    $this->assertTrue($cat_object->save());

    // Duplicate
    $cat_object = new CategoryObject();
    $cat_object->type = 'IND';
    $cat_object->form = 'NP';
    $cat_object->declination = 'ACC';
    
    $this->assertFalse( $cat_object->save() );
    $this->assertCount(1, $cat_object->errors()->all());
    
  }
  
  
}

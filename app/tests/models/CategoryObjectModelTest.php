<?php

class CategoryObjectModelTest extends TestCase
{

  /**
   * All fields are required (except has_preposition) and the other params should
   *  be restricted to some values (aka enumerators)
   */
  public function testCategoryObjectManage()
  {
    $cat_object = new CategoryObject();
    
    $cat_object->type = 'IND';
    $cat_object->form = 'NP';
    $cat_object->has_preposition = TRUE;
    
    // It should not work and the only error should be the required declination
    $this->assertFalse( $cat_object->save() );
    $errors = $cat_object->errors()->all();
    $this->assertCount(1, $errors);
    $this->assertEquals($errors[0], "The declination field is required.");

    $cat_object->declination = 'ACC';
    $this->assertTrue( $cat_object->save() );
    
    $id = $cat_object->id;


    // Loading the just created object
    $new_object = CategoryObject::find($id);
    $this->assertEquals('IND', $new_object->type);
    

    // Try to save with wrong data
    $wrong_object = clone $new_object;
    $wrong_object->type = 'ABC';
    $this->assertFalse( $wrong_object->save() );

    // If set correctly the object should be edited successfully
    $new_object->type = 'DIR';
    $this->assertTrue( $new_object->save() );
    
    // ID should not be changed.
    $this->assertEquals($id, $new_object->id);
    
    return $id;
  }

  
  /**
   * Duplicates should be detected!
   *
   * @depends testCategoryObjectManage
   */
  public function testDuplicateCategoryObject($old_id)
  {
    // $new_object = CategoryObject::find($old_id);
    $new_object = CategoryObject::all();
    
    var_dump($new_object);
    
    $cat_object = new CategoryObject();
    $cat_object->type = $new_object->type;
    $cat_object->form = $new_object->form;
    $cat_object->declination = $new_object->declination;
    $cat_object->has_preposition = $new_object->has_preposition;
    
    $this->assertFalse( $cat_object->save() );
    $this->assertTrue( $cat_object->errors()->has('type') );
    $this->assertCount( 1, $cat_object->errors()->all() );
  }
  
  
}

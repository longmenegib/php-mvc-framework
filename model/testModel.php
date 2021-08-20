<?php
    //import our model first
    require '../core/BaseModel.php';

    //create an array of item to be created in database
    $user=array(
        'name'=>'Awa',
        'email'=> 'awa$kdjf',
        'sexe'=> 'maleeee'
    );
    $userUpdate=array(
        'name'=>'Djoumesse',
        'email'=> 'gibri$kdjf',
        'sexe'=> 'female'
    );
   
    //create our first instance
    $users = new BaseModel();

    //display the data
    echo $users;

    //test for select data sans contrainte
 //   $users->select('name', "id=5 OR sexe='female'");
 $users->count();
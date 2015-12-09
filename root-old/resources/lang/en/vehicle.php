<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
   // vehicle listing table
    'table_plate_number'                    => 'Plate Number',
    'table_registration_number'             => 'Registation Number',
    'table_owner_name'                      => 'Owner Name',
    'table_owner_email'                     => 'Owner Email',
    'table_owner_phone'                     => 'Owner Phone',
    'table_chassis_number'                  => 'Chessis Number',
    'table_created_at'                      => 'Created At',
    'table_action'                          => 'Action',
   
   // page and buttons
    'create_page_heading'                   => 'Create a Vehicle',
    'update_page_heading'                   => 'Update a Vehicle',   
    'update_license_page'                   => 'Update Vehicle License',
    'breadcrumb_title'                      => 'Vehicles',
    'listing_page_heading'                  => 'Vehicles',
    'form_cancel_button'                    => 'Cancel',
    'form_save_button'                      => 'Save',
    'form_update_button'                    => 'Update', 
    'add_vehicle'                           =>  'Add Vehicle',
    // form fields
    'field_plate_number'                    => 'Plate Number',
    'field_vehicle_type'                    => 'Vehicle Type',
    'field_license_type'                    => 'License Type',
    'field_select_license_type'             => 'Select License Type',
    'field_registration_number'             => 'Registration Number',
    'field_owner_name'                      => 'Owner Name',
    'field_owner_email'                     => 'Owner Email',
    'field_owner_phone'                     => 'Owner Phone',
    'field_location'                        => 'Location',
    'field_chassis_number'                  => 'Chassis Number',
    'field_client'                          => 'Assign to',
    
    // validation messages
    'plate_number_error_message'            => 'Plate number is required',
    'vehicle_type_error_message'            => 'Vehicle type is required',
    'license_type_error_message'            => 'License type is required',

    //on save
    'vehicle_on_create'                     => 'Vehicle has been saved succussfully!',
    //on update
    'vehicle_on_update'                     => 'Vehicle has been updated succussfully!',
    // on delete
    'vehicle_on_delete'                     => 'Vehcile has been deleted succussfully!'      


];

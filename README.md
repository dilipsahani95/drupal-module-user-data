# drupal-module-user-data

* Install module user_details on your site.
* Go to the url "sitename/user-details".
* Fill the form and click on save. It will redirect to the url "sitename/user-details/display/table".
  here you can see the entered data.

* Showing last 5 users created.
* For performing Delete/Edit operation click on the button given.
  When you click on Edit button one url will open as "sitename/user-details?num=userid"
  e.g. https://example.com/user-details?num=5
  You can update and save the data. After saving it will redirect you on the display of data.

  When you click on Delete button one url will open as "sitename/user-details/form/delete/userid"
  e.g https://example.com/user-details/form/delete/5
  There will be confirmation message whether you want to delete or cancel.
  You can perform the action as per your requirement. If you will delete then user will be deleted, if cancel then user will not be deleted.
  After performing action it will redirect to the displaying data page.

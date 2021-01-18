# mini-orm-framework
a lightweight ORM framework for PHP with MySQL

Use a simple and vague DAO capable of handling basic CRUD operation.
you need to create classes reflecting your SQL tables with personalized methods that use the DAO ones as a base.
Use function.php to validate, sanitize and securise inputs as well as outputs

# TODO
<ul>
  <li>
    Fully employ the strengths of OOP by making search_table() return a desired model Class
  </li> 
  <li>
    <strong>Ensure security</strong> 
  </li> 
  <li>
    Add a update.php and delete.php as demonstration
  </li> 
  <li>
    While the system itself resists SQL injections, users named  " 'or TRUE; DROP DATABASE test;-- " shouldn't be able to have register. -> add a way to completely filter that type of 
    requests ↓
  </li> 
</ul>

![alt text](https://files.catbox.moe/9ssz86.png)

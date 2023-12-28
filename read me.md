What To do?

// search and category select don't work well together
category select should only include categories that are shown after search?
p.s. Until it is solved, category select is switched to "Category" everytime input is changed

// data_delete.php, want to remove if statement(->prepare() not working in else part)

// head commonalize  ← means head element??

// in practice, result is not shown coeewctly if choose answer including html characters
think again about where to apply str2html
str2html is needed for catch part of try/catch?

// if page-showing works correctly, set css styles and remove the old one.

//If push enter button when serach input is active, it shows an alert.
It can be stopped by doing below, but search input doesn't work then.
searchInput.onkeydown=(e)=>{ e.preventDefault(); }

// want to change structure of edit/delete part of each dataLi.

//$data1='(null, "'.$username.'", "breakthrough", "Sudden, dramatic and important discovery or development", "'.$category1.'", "'.$date.'", "'.$time.'")';
$data2='(null, "'.$username.'", "eventually", "In the end, especially after a long delay, dispute or series of problems.", "'.$category2.'", "'.$date.'", "'.$time.'")';
$data3='(null, "'.$username.'", "Break a leg", "A typical English idiom used in the context of theatre or other performing arts to wish a performer \"good luck\".", "'.$category3.'", "'.$date.'", "'.$time.'")';
$sql3="insert into words (id, user, word, meaning, category, date, time) values ".$data1.",".$data2.",".$data3."";

if add above data in DB and try to edit $data3, data is not called in edit page cuz it is using \"~\".
without it, it works.

/////////////////////////////////////////////////////////////////////////////////////////////////////
//where to need str2html?
login, create a new account, add data, edit (as of Aug 18 2023)

// window.alert dosn't work if header("location:../index/index.php"); follows right after.

// when assigning data received from database to input value attribute, they should be wrapped with "".
(check the whole code)

/////////////////////////////////////////////////////////////////////////////////////////////////////

//add
insert into words (id, user, word, meaning, category, date, time) values (null, :user, :word, :meaning, :category, :date, :time)

//regi
"insert into users (id, username, password) values (null, :user, :password)";

//update
"insert into categories (user, category) values (:user, :category)";
"update words set word=:word, meaning=:meaning, category=:category, date=:date, time=:time where words.id=:id";

//delete
"delete from words where id= :id";
"delete from categories where category= :category";

//login_check
"select * from users where users.username=:username";

//edit
"select * from words where words.id= :id";

//update, practice_pre, data, delete
'select * from words where user="'.$_SESSION["username"].'"';

//add_input, edit
'select * from categories where user="'.$_SESSION["username"].'"';

//update, delete
"select category from words where words.id= :id";

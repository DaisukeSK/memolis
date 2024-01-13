<?php
    require_once '../require/login_status_check.php';
    include '../include/input.php';

    $id=$_GET['id'];

    $dbh=db_open();

    $sql='select * from words where id= :id';
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    $term=$result["term"];
    $definition=$result["definition"];
    $categoryId=$result["categoryId"];
?>

<script src='../public/jquery-3.7.1.min.js'></script>
<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
<script>
    $('option[value="<?php echo $categoryId ?>"]').attr('selected',true)
    $('input[name="term"]').val('<?php echo $term;?>')
    $('textarea').text('<?php echo $definition;?>')
    $('input[name="id"]').val('<?php echo $id;?>')
    $('input[type="submit"]').val('Update')
    $('title').text('Edit data')
</script>
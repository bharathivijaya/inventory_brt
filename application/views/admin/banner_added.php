<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 17.04.15
 * Time: 14:21
 */
?>
<h2>Success</h2>
<p>Banner info has been successfully saved.
<?if ($answer == 'size') {
    echo "Unfortunately, image uploading failed because of the size exceeding.";
}
else if (($answer == 'error1') || ($answer == 'error2')) {
    echo "Unfortunately, image uploading failed because of an internal server error.";
}
else {
}?>
</p>
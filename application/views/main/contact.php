<h2><!--Contact us--><?=$page['pg_title']?></h2>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <!--
        <p>    MyRxPal, LLC</p>
        <p>    5003 Ritchie Highway</p>
        <p>    Brooklyn, MD 21225</p>
        <p>    Tel:</p>
        <p>    Fax:</p>
        <p>    E-mail:</p>
        -->
        <?=$page['pg_content']?>
    </div>
    <div class="col-md-5">
        <form action="" method="post" class="narrow">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="name" placeholder="Your Name" required class="form-control">
            </div>
            <div class="form-group">
                <label>Business Name</label>
                <input type="text" name="bname" placeholder="Business Name" required class="form-control">
            </div>
            <div class="form-group">
                <label>Your Email</label>
                <input type="email" name="email" placeholder="Your Email" required class="form-control">
            </div>
            <div class="form-group">
                <label>Contact Type</label>
                <select name="type"  class="form-control">
                    <option value="membership">Membership</option>
                    <option value="support">Support</option>
                    <option value="feedback">Feedback</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Your Comment</label>
                <textarea name="msg" class="form-control"></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Send">
        </form>
    </div>
</div>
<div class="col-md-1"></div>


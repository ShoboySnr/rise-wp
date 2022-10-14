<div style="max-width: 560px; padding: 20px; background: #FFFFFF; border-radius: 5px; margin: 40px auto; font-family: Open Sans,Helvetica,Arial; font-size: 15px; color: #666;">
    <div style="color: #444444; font-weight: normal;">
        <div style="text-align: center; font-weight: 600; font-size: 26px; padding: 10px 0; border-bottom: solid 3px #EEEEEE;">
            <img src="http://demo.rise-innovation.uk/wp-content/uploads/2021/07/rise-logo-website.svg" alt="" /></div>
    </div>
    <div style="padding: 0 30px 30px 30px; border-bottom: 3px solid #EEEEEE;">
        <div style="padding: 30px 0; font-size: 24px; text-align: center; line-height: 30px;">
            <p><span style="font-size: 12pt; color: #333333;">Hi <?= $first_name ?></span></p>
            <p><span style="font-size: 12pt; color: #333333;"><?= $reply_author_name ?> left a comment on your post on the RISE portal.</span></p>
            <p><span style="font-size: 12pt; color: #333333;"><a href="<?= $reply_url; ?>"> Click here</a> to view the comment</span></p>
        </div>
    </div>
    <div style="color: #999; padding: 20px 30px;">
        <div><span style="color: #333333;">You are receiving this email because you subscribed to receiving email notifications.</span></div>
        <div><span style="color: #333333;">Login and visit the account details page to update your notification preferences.</span></div>
    </div>
</div>
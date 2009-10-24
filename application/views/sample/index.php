<p>Oh hello there! I'm <?php echo $also; ?> <b>a view file</b>. I'm the part of Flimpl, which makes something <b>appear</b>! What I'm now telling you, is not something which is <b>dynamic</b> - no, no it's static! In fact, you can see how I look behind these bones and templates! I'm located around <b>/application/views/sample/index.php</b></p>

<p>But I'm <b>not</b> all static content, no no. I have a controller, she controls me! This means, I can retrieve information from her! Actually, my controller has something to say to me right now:<p>

<?php echo $task; ?>

<p>Oh damn, I gotta go. Hopefully you learned a bit about me and my mom! Oh, and you can meet my <?php echo $other; ?> <a href="<?php echo Html::anchor($link); ?>">here.</a></p>

<p>Validation was:
<b><?php echo ($this->validation) ? "Unsucessful" : "Successful"; ?></b>
</p>

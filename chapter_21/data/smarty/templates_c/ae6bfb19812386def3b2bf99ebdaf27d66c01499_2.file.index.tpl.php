<?php
/* Smarty version 3.1.30, created on 2016-10-10 19:24:41
  from "D:\RZECZY_ADAMA\_XAMPP\xampp-5.6\htdocs\zend3\module\Application\view\error\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57fbced9a03d59_99413965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ae6bfb19812386def3b2bf99ebdaf27d66c01499' => 
    array (
      0 => 'D:\\RZECZY_ADAMA\\_XAMPP\\xampp-5.6\\htdocs\\zend3\\module\\Application\\view\\error\\index.tpl',
      1 => 1468955106,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57fbced9a03d59_99413965 (Smarty_Internal_Template $_smarty_tpl) {
?>
<h1>An error occurred</h1>
<h2><?php echo '<?=';?> $this->message <?php echo '?>';?></h2>

<?php echo '<?php ';?>if (isset($this->display_exceptions) && $this->display_exceptions): <?php echo '?>';?>

<?php echo '<?php ';?>if(isset($this->exception) && ($this->exception instanceof Exception || $this->exception instanceof Error)): <?php echo '?>';?>
<hr/>
<h2>Additional information:</h2>
<h3><?php echo '<?=';?> get_class($this->exception) <?php echo '?>';?></h3>
<dl>
    <dt>File:</dt>
    <dd>
        <pre class="prettyprint linenums"><?php echo '<?=';?> $this->exception->getFile() <?php echo '?>';?>:<?php echo '<?=';?> $this->exception->getLine() <?php echo '?>';?></pre>
    </dd>
    <dt>Message:</dt>
    <dd>
        <pre class="prettyprint linenums"><?php echo '<?=';?> $this->escapeHtml($this->exception->getMessage()) <?php echo '?>';?></pre>
    </dd>
    <dt>Stack trace:</dt>
    <dd>
        <pre class="prettyprint linenums"><?php echo '<?=';?> $this->escapeHtml($this->exception->getTraceAsString()) <?php echo '?>';?></pre>
    </dd>
</dl>
<?php echo '<?php
    ';?>$e = $this->exception->getPrevious();
    $icount = 0;
    if ($e) :
<?php echo '?>';?>
<hr/>
<h2>Previous exceptions:</h2>
<ul class="unstyled">
    <?php echo '<?php ';?>while($e) : <?php echo '?>';?>
    <li>
        <h3><?php echo '<?=';?> get_class($e) <?php echo '?>';?></h3>
        <dl>
            <dt>File:</dt>
            <dd>
                <pre class="prettyprint linenums"><?php echo '<?=';?> $e->getFile() <?php echo '?>';?>:<?php echo '<?=';?> $e->getLine() <?php echo '?>';?></pre>
            </dd>
            <dt>Message:</dt>
            <dd>
                <pre class="prettyprint linenums"><?php echo '<?=';?> $this->escapeHtml($e->getMessage()) <?php echo '?>';?></pre>
            </dd>
            <dt>Stack trace:</dt>
            <dd>
                <pre class="prettyprint linenums"><?php echo '<?=';?> $this->escapeHtml($e->getTraceAsString()) <?php echo '?>';?></pre>
            </dd>
        </dl>
    </li>
    <?php echo '<?php
        ';?>$e = $e->getPrevious();
        $icount += 1;
        if ($icount >= 50) {
            echo "<li>There may be more exceptions, but we have no enough memory to proccess it.</li>";
            break;
        }
        endwhile;
    <?php echo '?>';?>
</ul>
<?php echo '<?php ';?>endif; <?php echo '?>';?>

<?php echo '<?php ';?>else: <?php echo '?>';?>

<h3>No Exception available</h3>

<?php echo '<?php ';?>endif <?php echo '?>';?>

<?php echo '<?php ';?>endif <?php echo '?>';
}
}

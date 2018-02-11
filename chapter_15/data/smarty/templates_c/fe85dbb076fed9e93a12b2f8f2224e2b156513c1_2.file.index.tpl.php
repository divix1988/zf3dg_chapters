<?php
/* Smarty version 3.1.30, created on 2016-10-10 19:24:41
  from "D:\RZECZY_ADAMA\_XAMPP\xampp-5.6\htdocs\zend3\module\Application\view\application\index\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57fbced9a23159_28746764',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fe85dbb076fed9e93a12b2f8f2224e2b156513c1' => 
    array (
      0 => 'D:\\RZECZY_ADAMA\\_XAMPP\\xampp-5.6\\htdocs\\zend3\\module\\Application\\view\\application\\index\\index.tpl',
      1 => 1476120279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout2.tpl' => 1,
  ),
),false)) {
function content_57fbced9a23159_28746764 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<div class="jumbotron">
    <h1><span class="zf-green">Zend Framework 3</span></h1>

    <p>
        Found user:<br /><br />
        Id: <?php echo '<?php ';?>echo $id; <?php echo '?>';?><br />
        Name: <?php echo '<?php ';?>echo $username; <?php echo '?>';?><br />
        Password: <?php echo '<?php ';?>echo $password; <?php echo '?>';?>
    </p>
<?php echo '<script'; ?>
 type="text/javascript">
    var variable = "<?php echo '<?=';?> $this->escapeJs('"; alert("XSS");') <?php echo '?>';?>";
<?php echo '</script'; ?>
>
</div>
<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:layout2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
}

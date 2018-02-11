<?php
/* Smarty version 3.1.30, created on 2016-10-10 21:26:09
  from "D:\RZECZY_ADAMA\_XAMPP\xampp-5.6\htdocs\zend3\module\Application\view\application\index\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57fbeb51cb72b1_25007053',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c1f98bc02bd5e8337fa2430105f7535898158ad6' => 
    array (
      0 => 'D:\\RZECZY_ADAMA\\_XAMPP\\xampp-5.6\\htdocs\\zend3\\module\\Application\\view\\application\\index\\index.tpl',
      1 => 1476127543,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/layout.tpl' => 1,
  ),
),false)) {
function content_57fbeb51cb72b1_25007053 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_510257fbeb51cb3439_59406984', 'content');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:layout/layout.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'content'} */
class Block_510257fbeb51cb3439_59406984 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="jumbotron">
        <h1><span class="zf-green">Zend Framework 3</span></h1>

        <p>
            Found user:<br /><br />
            Id: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
<br />
            Name: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['username']->value, ENT_QUOTES, 'UTF-8');?>
<br />
            Password: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['password']->value, ENT_QUOTES, 'UTF-8');?>

        </p>
    </div>
<?php
}
}
/* {/block 'content'} */
}

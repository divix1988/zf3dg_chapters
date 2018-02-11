<?php
/* Smarty version 3.1.30, created on 2016-10-10 21:26:09
  from "D:\RZECZY_ADAMA\_XAMPP\xampp-5.6\htdocs\zend3\module\Application\view\layout\layout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57fbeb51cf9948_19019820',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da2d13704c732a92be2bed353de4f65b9c284e98' => 
    array (
      0 => 'D:\\RZECZY_ADAMA\\_XAMPP\\xampp-5.6\\htdocs\\zend3\\module\\Application\\view\\layout\\layout.tpl',
      1 => 1476127336,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57fbeb51cf9948_19019820 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<html lang="en">
        
    <head>
        <meta charset="utf-8">
        <title>ZF Skeleton Application</title>
        <link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- Scripts -->
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/js/jquery-2.2.4.min.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
">
                        <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/img/zf-logo.png" alt="Zend Framework 3"/>&nbsp;Skeleton Application
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
">Home Page</a></li>
                        <li class=""><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/users/index">Users</a></li>
                        <li class=""><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/news/index">Articles</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2844457fbeb51ce9f45_78463043', 'content');
?>

            <hr>
            <footer>
                <p>&copy; 2005 - <?php echo '<?=';?> date('Y') <?php echo '?>';?> by Zend Technologies Ltd. All rights reserved.</p>
            </footer>
        </div>
    </body>
</html>
<?php }
/* {block 'content'} */
class Block_2844457fbeb51ce9f45_78463043 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content'} */
}

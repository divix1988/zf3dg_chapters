{extends 'layout/layout.tpl'}
{block 'content'}
    <div class="jumbotron">
        <h1><span class="zf-green">Zend Framework 3</span></h1>

        <p>
            Found user:<br /><br />
            Id: {$id}<br />
            Name: {$username}<br />
            Password: {$password}
        </p>
    </div>
{/block}
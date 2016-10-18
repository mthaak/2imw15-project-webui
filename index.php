<?php
include 'elasticsearch/es_get_topk_users.php';
if (isset($_POST['search_query'])) {
    include 'elasticsearch/es_get_rumors.php';
} else {
    $rumors = [];
    $_POST['search_query'] = "";
}
include 'content.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brexit Truthifier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://bootswatch.com/lumen/bootstrap.min.css"/>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<div id="LeftSide" class="col-md-2">
    <div id="LeftSideImage"></div>
</div>
<div id="Middle" class="col-md-8">
    <div class="col-md-12 ">
        <div id="TitleBar" class="panel">
            <h1>Brexit Truthifier</h1>
        </div>
        <div id="SearchBar" class="navbar navbar-default panel-primary">
            <form id="SearchForm" action="" method="post" class="navbar-form navbar-left">
                <input type="hidden" name="test" value="hey"/>
                <div id="SearchBoxContainer" class="form-group">
                    <input id="SearchBox" class="form-control" name="search_query" type="text"
                           placeholder="type keywords"/>
                </div>
                <button id="SearchButton" class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div id="left_side" class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">Rumors related to <b><?php echo($_POST['search_query']); ?></b></div>
            <div id="rumor_list" class="panel-body">
                <?php
                $rumor_html = '
                    <div class="Rumor panel">
                        <div class="panel-body">
                        <h4>%representative_tweet%</h4>
                        <b>Variations:</b>
                        <div class="VariationsList well">
                            %variations%
                        </div>
                        <p><b>Popularity:</b> %popularity%</p>
                        <p><b>Veracity:</b> %veracity%</p>
                        
                        <p class="RumorProducersList"><b>Top producers:</b> %producers%</p>
                        <p class="RumorPropagatorsList"><b>Top propagators:</b> %propagators%</p>
                        <p class="RumorStiflerList"><b>Top stiflers:</b> %stiflers%</p>
                        </div>
                    </div>';
                array_walk($rumors, function ($rumor) use ($rumor_html) {
                    echo(convertRumorToHtml($rumor, $rumor_html, $_POST["search_query"]));
                });
                ?>
            </div>
        </div>

    </div>

    <div id="right_side" class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Top rumor producers</div>
            <ul id="producers_list" class="list-group">
                <?php
                $producer_html = '
                    <span class="list-group-item">
                        <h4>%user_screen_name%</h4>
                        <table class="UserPropertyTable">
                            <tr><td class="UserPropertyName">Rumors produced</td><td class="UserPropertyVal">%n_rumors_produced%</td></tr>
                            <tr><td class="UserPropertyName">Influence</td><td class="UserPropertyVal">%influence%</td></tr>
                            <tr><td class="UserPropertyName">Credibility</td><td class="UserPropertyVal">%credibility%</td></tr>
                        </table>
                    </span>';
                array_walk($top_producers, function ($producer) use ($producer_html) {
                    echo(convertUserToHtml($producer, $producer_html));
                });
                ?>
            </ul>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Top propagators</div>
            <ul id="propagators_list" class="list-group">
                <?php
                $propagator_html = '
                    <span class="list-group-item">
                        <h4>%user_screen_name%</h4>
                        <table class="UserPropertyTable">
                            <tr><td class="UserPropertyName">Rumors propagated</td><td class="UserPropertyVal">%n_rumors_propagated%</td></tr>
                            <tr><td class="UserPropertyName">Influence</td><td class="UserPropertyVal">%influence%</td></tr>
                            <tr><td class="UserPropertyName">Credibility</td><td class="UserPropertyVal">%credibility%</td></tr>
                        </table>
                    </span>';
                array_walk($top_propagators, function ($propagator) use ($propagator_html) {
                    echo(convertUserToHtml($propagator, $propagator_html));
                });
                ?>
            </ul>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Top stiflers</div>
            <ul id="stiflers_list" class="list-group">
                <?php
                $stifler_html = '
                    <span class="list-group-item">
                        <h4>%user_screen_name%</h4>
                        <table class="UserPropertyTable">
                            <tr><td class="UserPropertyName">Rumors stifled</td><td class="UserPropertyVal">%n_rumors_stifled%</td></tr>
                            <tr><td class="UserPropertyName">Influence</td><td class="UserPropertyVal">%influence%</td></tr>
                            <tr><td class="UserPropertyName">Credibility</td><td class="UserPropertyVal">%credibility%</td></tr>
                        </table>
                    </span>';
                array_walk($top_stiflers, function ($stifler) use ($stifler_html) {
                    echo(convertUserToHtml($stifler, $stifler_html));
                });
                ?>
            </ul>
        </div>
    </div>
</div>
<div id="RightSide" class="col-md-2">
    <div id="RightSideImage"></div>
</div>
</body>
</html>
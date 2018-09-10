<script type="text/javascript">
        $(document).ready(function() {
            $("#search_bar").autocomplete('autocomplete_search_bar.php?', {
                autoFill: true,
                delay: 200,
                max: 0,
                multiple: false, 
                minChars: 2,
                mustMatch: false
            });
        });
</script>

<div id="top_search">
    <form method="get" action="result_search_bar.php">
        <p>
            <input type="text" name="search_bar" id="search_bar" onclick="value=''" onblur="if (!value) value='Search gene'" value="Search gene" title="search"/>
            <input type="image" src="images/submit.png" value="" title="Search" alt="Search"/>
        </p>
    </form>
</div>
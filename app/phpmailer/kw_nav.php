
    <?php
    $aktuelle_kw_start_ts = mktime(12, 0, 0, $show_woche_startmonat, $show_woche_starttag, $show_woche_startjahr);
    $prev_woche_tag = date('d', $aktuelle_kw_start_ts - 7 * 86400);
    $prev_woche_monat = date('m', $aktuelle_kw_start_ts - 7 * 86400);
    $prev_woche_jahr = date('Y', $aktuelle_kw_start_ts - 7 * 86400);
    $next_woche_tag = date('d', $aktuelle_kw_start_ts + 7 * 86400);
    $next_woche_monat = date('m', $aktuelle_kw_start_ts + 7 * 86400);
    $next_woche_jahr = date('Y', $aktuelle_kw_start_ts + 7 * 86400);

    $look_key = $prev_woche_tag . "_" . $prev_woche_monat . "_" . $prev_woche_jahr;
    $anzahl_kws = count($anzeigbare_kws_array);
    $erste_kw_tag_str = date('d', $anzeigbare_kws_array[0]) . date('m', $anzeigbare_kws_array[0]) . date('Y', $anzeigbare_kws_array[0]);
    $last_kw_tag_str = date('d', $anzeigbare_kws_array[$anzahl_kws - 1]) . date('m', $anzeigbare_kws_array[$anzahl_kws - 1]) . date('Y', $anzeigbare_kws_array[$anzahl_kws - 1]);
    $class_disabled = '';
    $class_disabled2 = '';
    if ($erste_kw_tag_str == $show_woche_starttag . $show_woche_startmonat . $show_woche_startjahr) {
        $class_disabled = 'disabled';
    }
    if ($last_kw_tag_str == $show_woche_starttag . $show_woche_startmonat . $show_woche_startjahr) {
        $class_disabled2 = 'disabled';
    }
    ?>
<div class='clearfix kw_nav_panel'>
 <?php if(!$class_disabled) { ?>
    <a class="left"  href="index.php?action=bestellen&sd=<?php echo $prev_woche_tag ?>&sm=<?php echo $prev_woche_monat ?>&sy=<?php echo $prev_woche_jahr ?>">
        <i class="fi-arrow-left size-36"></i>
    </a>
 <?php } ?>
    <ul class="button-group kw_nav small-even-<?php echo count($anzeigbare_kws_array)/2 ?> medium-even-<?php echo count($anzeigbare_kws_array)/2 ?>" >    
        <?php
        $sess_arr_values = array_values($anzeigbare_kws_array);
        foreach ($anzeigbare_kws_array as $k_key => $kw_button) {

            if ($show_woche_starttag . $show_woche_startmonat . $show_woche_startjahr === date('d', $kw_button) . date('m', $kw_button) . date('Y', $kw_button)) {

                $active_class = 'success';
            } else {
                $active_class = 'secondary';
            }
            $tag_ger = ermittleDeutschenWochentag($kw_button);
            ?>
            <li>
                <a class='button <?php echo $active_class ?>' href="javascript:navigator_Go('index.php?action=bestellen&sd=<?php echo date('d', $kw_button) ?>&sm=<?php echo date('m', $kw_button) ?>&sy=<?php echo date('Y', $kw_button) ?>')">
                    <span class=''>KW <?php echo date('W', $kw_button); ?></span>
                    <span class='size-12 '>ab <?php echo $tag_ger['short'] ?> <?php echo date('d', $kw_button) ?>.<?php echo date('m', $kw_button) ?>.</span>
                    <span class="label  right secondary"><?php echo $anz_bestellungen_zu_woche_arr[$k_key] ?> <i class="fi-shopping-cart size-16 kf_green"></i><?php count($bestellungen_zu_woche) ?></span>
                </a></li>
        <?php } ?>
    </ul>
 <?php if(!$class_disabled2) { ?>
    <a class="right" href="index.php?action=bestellen&sd=<?php echo $next_woche_tag ?>&sm=<?php echo $next_woche_monat ?>&sy=<?php echo $next_woche_jahr ?>">
        <i class="fi-arrow-right size-36"></i>
    </a>
 <?php } ?>
    
</div>
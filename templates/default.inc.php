<main id="main">
<?php

echo  $this->_['month_changer'];

?>
<div class="content content_small">
    <table id="data">
        <tr>
            <th></th>
            <th class="concerts_table_date">Date</th>
            <th>Name</th>
            <th>Venue</th>
            <th>Bands</th>
            <th>URL</th>
            <th>Admin</th>
        </tr>
<?php

foreach ($this->_['concerts'] as $concert) {
    $bands = '';
    foreach ($concert['bands'] as $band) {
        if ($band['zusatz']) :
            $bands = $bands . sprintf(
                ', <span class="%3$s">%1$s (%2$s)</span>',
                htmlspecialchars($band['name'] ?? '', ENT_QUOTES),
                htmlspecialchars($band['zusatz'], ENT_QUOTES),
                htmlspecialchars($band['visible'], ENT_QUOTES)
            );
        else :
            $bands = $bands . sprintf(
                ', <span class="%2$s">%1$s</span>',
                htmlspecialchars($band['name'] ?? '', ENT_QUOTES),
                htmlspecialchars($band['visible'], ENT_QUOTES)
            );
        endif;
    }
    $bands = substr($bands, 2);
    printf(
        "\t\t<tr id=\"concert_high_%9\$s\" class='concert_%1\$s concert_high_closed'>
			<td><a href=\"#\" onclick=\"display_concert('%9\$u', '%1\$s')\" >
				<img src=\"%10\$s\" alt=\"open export\" id=\"image_%9\$s\" width=\"15\" height=\"15\">
			</a></td>
			<td>%2\$s</td>
			<td>%3\$s</td>
			<td>%4\$s</td>
			<td>%6\$s</td>
			<td><a class='%1\$s' href='%5\$s'>www</a></td>
			<td class=\"table_elements\">
				<form action=\"\" method=\"GET\" id=\"%9\$u\">
                    <input type=\"hidden\" name=\"special\" value=\"concert\">
                    <label for=\"type_%9\$s\" class=\"screenreader_only\">Chose an action</label>
					<select name=\"type\" id=\"type_%9\$s\">
						<option value=\"add\">Add</option>
						<option value=\"edit\">Edit</option>
						<option value=\"published\">Published</option>
						<option value=\"del\">Del</option>
						<option value=\"sold_out\">Sold Out</option>
					</select>
					<input type=\"hidden\" name=\"month\" value=\"%8\$s\">
					<input type=\"hidden\" name=\"id\" value=\"%9\$u\">
					<input type=\"hidden\" name=\"date_start\" value=\"%7\$s\">
					<button type=\"submit\" form=\"%9\$u\">Ok</button>
				</form>
			</td>
		</tr>
		<tr class='concert_%1\$s concert_low'>
			<td id=\"concert_low_%9\$s\" colspan=\"7\"></td>
        </tr>\n",
        htmlspecialchars($concert['status'], ENT_QUOTES),
        $concert['date_human'],
        htmlspecialchars($concert['name'], ENT_QUOTES),
        htmlspecialchars($concert['venue_city'], ENT_QUOTES),
        htmlspecialchars($concert['url'], ENT_QUOTES),
        $bands,
        $concert['date_start'],
        $this->_['month'],
        $concert['id'],
        $this->image_path . DIRECTORY_SEPARATOR . 'plus_small.png'
    );
}
?>
        </table>
    </div>
</main>

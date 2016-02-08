//add data

var desc;
var dwg;
var type;
var supplier;
var sup_part;
var img;

var dataStrings[] = new Array(
	'descr=Trojan%20Flushbox%20Lid&type=1&drawing_number=351-101&supplierid=2&sup_part_number=35T-101',

	);



$.ajax({
type: "POST",
url: "index.php",
data: dataString,
cache: false,
success: function(html) {
alert(html);
}
});
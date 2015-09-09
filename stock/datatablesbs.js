
        
        
        
        
        
        
		
		
"drawCallback": function ( settings, row, data, start, end, display ) {
var api = this.api();
var rows = api.rows( {page:'current'} ).nodes();
var last=null;
			
// Remove the formatting to get integer data for summation
var intVal = function ( i ) {
return typeof i === 'string' ?
i.replace(/[\£,]/g, '')*1 :
typeof i === 'number' ?
i : 0;
};
 
// Total over all pages
total = api
.column( 4 )
.data()
.reduce( function (a, b) {
return intVal(a) + intVal(b);
} );
 
// Total over this page
pageTotal = api
.column( 4, { page: 'current'} )
.data()
.reduce( function (a, b) {
return intVal(a) + intVal(b);
}, 0 );
 
// Update footer
$( api.column( 4 ).footer() ).html(
'£'+pageTotal.toFixed(2) +' (£'+ total.toFixed(2) +' total)'
);

} );






api.column(0, {page:'current'} ).data().each( function ( group, i ) {
if ( last !== group ) {
$(rows).eq( i ).before(
'<tr class="group"><td colspan="10">'+group+'</td></tr>'
);
 
last = group;
}
} );
 
    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
            table.order( [ 0, 'desc' ] ).draw();
        }
        else {
            table.order( [ 0, 'asc' ] ).draw();
        }
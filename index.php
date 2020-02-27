<div class="form">
    <button onclick="getDataFromServer('https://api.exchangeratesapi.io/latest', 1)">1st API call</button>
    <div class="container">
        <span>Result for the 1st call:</span>
        <span id="1st_result"></span><br/>
        <span id="1st_timer"></span>
    </div>
    
    <button onclick="getDataFromServer('https://restcountries.eu/rest/v2/all', 2)">2nd API call</button>
    <div class="container">
        <span>Result for the 2nd call:</span>
        <span id="2nd_result"></span><br/>
        <span id="2nd_timer"></span>
    </div>
    
    <button onclick="getDataFromServer('https://api.frankfurter.app/latest', 3)">3rd API call</button>
    <div class="container">
        <input type="text" placeholder="Amount..." id="amount"/><br/>
        <span>Result for the 3rd call:</span>
        <span id="3rd_result"></span><br/>
        <span id="3rd_timer"></span>
    </div>
    
    <button onclick="getMetrics()">Metrics</button>
    
</div>
<div class="html-container">
        <span id="html"></span>
</div>

<script>
 
	function getDataFromServer(url, result_type){
        if ( result_type == 3 ) {
            let amount = parseFloat(document.getElementById( 'amount' ).value) * parseFloat( document.getElementById( '1st_result' ).getAttribute( 'data-amount' ) );
            url = url + "?amount=" + amount + "&from=RON&to=" + document.getElementById( '2nd_result' ).getAttribute( 'data-currency' );

        }
	    
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var timer = performance.now();
            if ( xhr.status >= 200 && xhr.status < 300 ) {
                var timer_2 = performance.now();

                console.log("Status: " + xhr.status);
                console.log("Status Text: " + xhr.statusText);
                console.log("Response: " + xhr.response);
                
                var result = JSON.parse( xhr.responseText );
                if ( result_type == 1 ) {
                    
                    document.getElementById( '1st_result' ).innerText = '1 Euro = ' + result['rates']["RON"] + ' RON';
                    document.getElementById( '1st_timer' ).innerText = (timer_2 - timer) + ' seconds';
                    document.getElementById( '1st_result' ).setAttribute('data-amount', result['rates']["RON"]);
                }
                if ( result_type == 2 ) {
                    for (let i = 0 ; i <= result.length; i++ )
                    {
                        if ( result[i].name == 'Bulgaria' ) {
                            document.getElementById( '2nd_result' ).innerText = 'Bulgaria Currency - ' + result[i].currencies[0]['code'];
                            document.getElementById( '2nd_timer' ).innerText = (timer_2 - timer) + ' seconds';
                            document.getElementById( '2nd_result' ).setAttribute('data-currency',result[i].currencies[0]['code']);
                            break;
                        }
                    }
                }
                if ( result_type == 3 ) {
                    document.getElementById( '3rd_result' ).innerText = result['rates']["BGN"] + ' ' + document.getElementById( '2nd_result' ).getAttribute( 'data-currency' );
                    document.getElementById( '3rd_timer' ).innerText = (timer_2 - timer) + ' seconds';

                }
                console.log(timer_2 - timer);
            }
            else {
                console.log( 'The request failed!' );
            }
        };
        url = encodeURIComponent(url);
        xhr.open( 'GET', 'apicall.php?url=' + url );
        xhr.send();
    }
    
    function getMetrics(){
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            if ( xhr.status >= 200 && xhr.status < 300 ) {
                var data = JSON.parse( xhr.responseText );
                document.getElementById('html').innerHTML = data['html'];
            }
            else {
                console.log( 'The request failed!' );
            }
        };
        xhr.open( 'GET', 'http://localhost:8008/metrics.php');
        xhr.send();
    }
</script>
<style>
    .form{
        width: 35%;
        height : 400px;
        margin : 80px auto;
        text-align : center ;
        display : flex;
        flex-direction : column;
    }
    
    .form button{
        width : 50%;
        margin: 0 auto;
        text-align : center;
    }
    
    .container{
        margin-bottom : 40px;
    }
    
    .form input{
        width: 50%;
        text-align : center;
        margin : 0 auto;
    }
    .html-container #html{
        display : flex;
        flex-direction : column;
        width  : 50%;
        margin : 0 auto;
    }
    
    #html span{
        margin: 50px auto;
    }
</style>

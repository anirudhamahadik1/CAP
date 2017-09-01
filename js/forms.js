function updateFormData(){
	var cap = document.getElementById("cap").value;
	var concilHandle = document.getElementById("conhand").value;
	var totalAmount = document.getElementById("totalamount").innerHTML;
	var taxAmount = document.getElementById("taxamount").innerHTML;
	var labour = document.getElementById("labour").value;
	var netAmount = document.getElementById("netamount").innerHTML;
	
	if(cap == ""){
		cap = 0;
	}
	if(concilHandle == ""){
		concilHandle = 0;
	}
	if(labour == ""){
		labour = 0;
	}
	
	totalAmount = parseFloat(totalAmount) + parseFloat(cap) + parseFloat(concilHandle);
	taxAmount = (28 / 100) * parseFloat(totalAmount);
	netAmount = parseFloat(totalAmount) + parseFloat(taxAmount) + parseFloat(labour);
	
	document.getElementById("distotalamount").innerHTML = totalAmount.toFixed(2);
	document.getElementById("distaxamount").innerHTML = taxAmount.toFixed(2);
	document.getElementById("disnetamount").innerHTML = netAmount.toFixed(2);
}
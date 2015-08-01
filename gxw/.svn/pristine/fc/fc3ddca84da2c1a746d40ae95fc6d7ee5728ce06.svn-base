function OnezEncode(str,ifTurn){
  if(ifTurn==0)return str;
  
  str=escape(str);
  var onezStr='';
  for (i=0;i<str.length;i++){
    onezStr+=str.charCodeAt(i)^0x12;
    onezStr+=".";
  }
  str=onezStr;
  
  return str;
}
function OnezDecode(str,ifTurn){
  if(ifTurn==0)return str;
  
  var onezStr='';
  var k=str.split("."); 
  for(i=0;i<k.length-1;i++) { 
    onezStr+=String.fromCharCode(k[i]^0x12); 
  }
  str=onezStr;
  str=unescape(str);

  return str;
}
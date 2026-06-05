function error(){
    const id=document.getElementById("idnumber").value;
    const pass=document.getElementById("password").value;
    if ((id.length!=8)||(pass_vrif(pass)==false))
    {
        alert("try again the id must contain EXACTLY and ur password should be upper cased and 8 degit");
        return false;
    }
    function pass_vrif (pass) {
        for( i=0; i<=pass.length; i++)
        {
            const chr= pass.charAt(i);
            if(chr===" ")
            {
                alert("Il ya un espace dans ta code");
                return false;
            }
            if(chr<"A"||chr>"Z")
            {
                alert("your password should be uppercased only");
                return false;
            }
            return true;
        }
    }


}
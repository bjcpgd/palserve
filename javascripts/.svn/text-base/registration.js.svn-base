var require = new Array( 'firstname','lastname','company','email' );
var country_index = '0';

function checkPrintReview( theForm ) {
  if ( theForm.print_review.checked ) {
    require = new Array( 'firstname','lastname','company','email',
        'address1','city','state','province','zip','postal','country' );
    document.getElementById( 'address_label' ).innerHTML =
        "Address:<span class=\"style1\">*</span>";
    document.getElementById( 'city_label' ).innerHTML =
        "City:<span class=\"style1\">*</span>";
    document.getElementById( 'state_label' ).innerHTML =
        "State:<span class=\"style1\">*</span>";
    document.getElementById( 'province_label' ).innerHTML =
        "Province:<span class=\"style1\">*</span>";
    document.getElementById( 'zip_label' ).innerHTML =
        "Zip Code:<span class=\"style1\">*</span>";
    document.getElementById( 'postal_label' ).innerHTML =
        "Postal Code:<span class=\"style1\">*</span>";
    document.getElementById( 'country_label' ).innerHTML =
        "Country:<span class=\"style1\">*</span>";
  } else {
    require = new Array( 'firstname','lastname','company','email' );
    document.getElementById( 'address_label' ).innerHTML =
        "Address:";
    document.getElementById( 'city_label' ).innerHTML =
        "City";
    document.getElementById( 'state_label' ).innerHTML =
        "State:";
    document.getElementById( 'province_label' ).innerHTML =
        "Province:";
    document.getElementById( 'zip_label' ).innerHTML =
        "Zip Code";
    document.getElementById( 'postal_label' ).innerHTML =
        "Postal Code:";
    document.getElementById( 'country_label' ).innerHTML =
        "Country:";
  }
}

function showAlumnus() {
  if ( navigator.appName == "Microsoft Internet Explorer" ) {
    document.getElementById( 'alumnus_row' ).style.display = "block";
  } else {
    document.getElementById( 'alumnus_row' ).style.display = "table-row";
  }
}

function hideAlumnus() {
  document.getElementById( 'alumnus_row' ).style.display = "none";
}

function viewUS() {
  document.getElementById( 'province_row' ).style.display = "none";
  document.getElementById( 'country_row' ).style.display = "none";
  document.getElementById( 'postal_row' ).style.display = "none";
  if ( navigator.appName == "Microsoft Internet Explorer" ) {
    document.getElementById( 'state_row' ).style.display = "block";
    document.getElementById( 'zip_row' ).style.display = "block";
  } else {
    document.getElementById( 'state_row' ).style.display = "table-row";
    document.getElementById( 'zip_row' ).style.display = "table-row";
  }
  // select US as country
  country_index = document.reg.country.selectedIndex;
  document.getElementById( 'us_option').selected = true;
}

function viewInternational() {
  document.reg.country.options[country_index].selected = true;
  if ( navigator.appName == "Microsoft Internet Explorer" ) {
    document.getElementById( 'province_row').style.display = "block";
    document.getElementById( 'country_row').style.display = "block";
    document.getElementById( 'postal_row').style.display = "block";
  } else {
    document.getElementById( 'province_row').style.display = "table-row";
    document.getElementById( 'country_row').style.display = "table-row";
    document.getElementById( 'postal_row').style.display = "table-row";
  }
  document.getElementById( 'state_row').style.display = "none";
  document.getElementById( 'zip_row').style.display = "none";
}

function checkEmail (emailStr) {
  
  if (!emailStr=="") {
    /* The following variable tells the rest of the function whether or not
    to verify that the address ends in a two-letter country or well-known
    TLD.  1 means check it, 0 means don't. */
    
    var checkTLD=1;
    
    /* The following is the list of known TLDs that an e-mail address must end with. */
    
    var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
    
    /* The following pattern is used to check if the entered e-mail address
    fits the user@domain format.  It also is used to separate the username
    from the domain. */
    
    var emailPat=/^(.+)@(.+)$/;
    
    /* The following string represents the pattern for matching all special
    characters.  We don't want to allow special characters in the address. 
    These characters include ( ) < > @ , ; : \ " . [ ] */
    
    var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    
    /* The following string represents the range of characters allowed in a 
    username or domainname.  It really states which chars aren't allowed.*/
    
    var validChars="\[^\\s" + specialChars + "\]";
    
    /* The following pattern applies if the "user" is a quoted string (in
    which case, there are no rules about which characters are allowed
    and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
    is a legal e-mail address. */
    
    var quotedUser="(\"[^\"]*\")";
    
    /* The following pattern applies for domains that are IP addresses,
    rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
    e-mail address. NOTE: The square brackets are required. */
    
    var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
    
    /* The following string represents an atom (basically a series of non-special characters.) */
    
    var atom=validChars + '+';
    
    /* The following string represents one word in the typical username.
    For example, in john.doe@somewhere.com, john and doe are words.
    Basically, a word is either an atom or quoted string. */
    
    var word="(" + atom + "|" + quotedUser + ")";
    
    // The following pattern describes the structure of the user
    
    var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
    
    /* The following pattern describes the structure of a normal symbolic
    domain, as opposed to ipDomainPat, shown above. */
    
    var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
    
    /* Finally, let's start trying to figure out if the supplied address is valid. */
    
    /* Begin with the coarse pattern to simply break up user@domain into
    different pieces that are easy to analyze. */
    
    var matchArray=emailStr.match(emailPat);
    
    if (matchArray==null) {
      
      /* Too many/few @'s or something; basically, this address doesn't
      even fit the general mould of a valid e-mail address. */
      
      alert("E-mail address is not a valid address.");
      return false;
    }
    var user=matchArray[1];
    var domain=matchArray[2];
    
    // Start by checking that only basic ASCII characters are in the strings (0-127).
    
    for (i=0; i<user.length; i++) {
      if (user.charCodeAt(i)>127) {
        alert("Ths username contains invalid characters.");
        return false;
      }
    }
    for (i=0; i<domain.length; i++) {
      if (domain.charCodeAt(i)>127) {
        alert("Ths domain name contains invalid characters.");
        return false;
      }
    }
    
    // See if "user" is valid 
    
    if (user.match(userPat)==null) {
      // user is not valid
      alert("The username doesn't seem to be valid.");
      return false;
    }
    
    /* if the e-mail address is at an IP address (as opposed to a symbolic
    host name) make sure the IP address is valid. */
    
    var IPArray=domain.match(ipDomainPat);
    if (IPArray!=null) {
    
      // this is an IP address
      for (var i=1;i<=4;i++) {
        if (IPArray[i]>255) {
          alert("Destination IP address is invalid!");
          return false;
        }
      }
      return true;
    }
    
    // Domain is symbolic name.  Check if it's valid.
     
    var atomPat=new RegExp("^" + atom + "$");
    var domArr=domain.split(".");
    var len=domArr.length;
    for (i=0;i<len;i++) {
      if (domArr[i].search(atomPat)==-1) {
        alert("The domain name does not seem to be valid.");
        return false;
      }
    }
    
    /* domain name seems valid, but now make sure that it ends in a
    known top-level domain (like com, edu, gov) or a two-letter word,
    representing country (uk, nl), and that there's a hostname preceding 
    the domain or country. */
    
    if (checkTLD && domArr[domArr.length-1].length!=2 && 
        domArr[domArr.length-1].search(knownDomsPat)==-1) {
      alert("The E-mail address does not have a valid ending.");
      return false;
    }
    
    // Make sure there's a host name preceding the domain.
    
    if (len<2) {
      alert("This address is missing a hostname!");
      return false;
    }
    
    // If we've gotten this far, everything's valid!
    return true;
  } else {
    return false;
  }
}

function regValidate( theForm ) {
  var valid = true;
  
  var themessage = "You are required to complete the following fields: ";

  // Validate email and return if fails
  if ( !checkEmail( theForm.email.value) ) {
    alert("Please enter a valid email address");
    return false;
  }

  // Validate first, last, and company always
  if (theForm.firstname.value == "" ) {
    valid = false;
    themessage+="\n\tFirst Name";
  }
  if (theForm.lastname.value == "" ) {
    valid = false;
    themessage+="\n\tLast Name";
  }
  if (theForm.company.value == "" ) {
    valid = false;
    themessage+="\n\tCompany";
  }

  // Validate address, city, state, zip (province, postal, country)
  //  if print-review is checked
  if ( theForm.print_review.checked ) {
    if (theForm.address1.value == "" ) {
      valid = false;
      themessage+="\n\tAddress";
    }
    if (theForm.city.value == "" ) {
      valid = false;
      themessage+="\n\tCity";
    }
    // Depending on international or US
    if ( theForm.geography[0].checked ) {
      if (theForm.state.value == "" ) {
        valid = false;
        themessage+="\n\tState";
      }
      if (theForm.zip.value == "" ) {
        valid = false;
        themessage+="\n\tZip";
      }
    } else {
      if (theForm.province.value == "" ) {
        valid = false;
        themessage+="\n\tProvince";
      }
      if (theForm.postal.value == "" ) {
        valid = false;
        themessage+="\n\tPostal Code";
      }
      if (theForm.country.value == "" ) {
        valid = false;
        themessage+="\n\tCountry";
      }
    }
  }
  //alert if fields are empty and cancel form submit
  if (! valid ) {
    alert(themessage);
  }
  return valid;
}
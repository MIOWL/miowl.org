

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>
    Log in to your Bitbucket account
</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="Log in to your Bitbucket account." />
  <meta name="keywords" content="code hosting free bitbucket mercurial subversion git free" />
  <!--[if lt IE 9]>
  <script src="https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/js/lib/html5.js"></script>
  <![endif]-->

  <script>
    (function (window) {
      // prevent stray occurrences of `console.log` from causing errors in IE
      var console = window.console || (window.console = {});
      console.log || (console.log = function () {});

      var BB = window.BB || (window.BB = {});
      BB.debug = false;
      BB.cname = false;
      BB.CANON_URL = 'https://bitbucket.org';
      BB.MEDIA_URL = 'https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/';
      BB.images = {
        invitation: 'https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/img/icons/fugue/card_address.png',
        noAvatar: 'https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/img/no_avatar.png'
      };
      BB.user = {"isKbdShortcutsEnabled": true, "isSshEnabled": false};
      BB.user.has = (function () {
        var betaFeatures = [];
        betaFeatures.push('repo2');
        return function (feature) {
          return _.contains(betaFeatures, feature);
        };
      }());
      BB.targetUser = BB.user;
  
      BB.repo || (BB.repo = {});
  
    }(this));
  </script>

  


  <link rel="stylesheet" href="https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/bun/css/bundle.css"/>



  <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Bitbucket" />
  <link rel="icon" href="https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/img/logo_new.png" type="image/png" />
  <link type="text/plain" rel="author" href="/humans.txt" />


  
  
    <script src="https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/bun/js/bundle.js"></script>
  



</head>

<body id="" class=" ">
  <script>
    if (navigator.userAgent.indexOf(' AppleWebKit/') === -1) {
      $('body').addClass('non-webkit')
    }
    $('body')
      .addClass($.client.os.toLowerCase())
      .addClass($.client.browser.toLowerCase())
  </script>
  <!--[if IE 8]>
  <script>jQuery(document.body).addClass('ie8')</script>
  <![endif]-->
  <!--[if IE 9]>
  <script>jQuery(document.body).addClass('ie9')</script>
  <![endif]-->

  <div id="wrapper">



  <div id="header-wrap">
    <div id="header">
    <ul id="global-nav">
      <li><a class="home" href="http://www.atlassian.com">Atlassian Home</a></li>
      <li><a class="docs" href="http://confluence.atlassian.com/display/BITBUCKET">Documentation</a></li>
      <li><a class="support" href="/support">Support</a></li>
      <li><a class="blog" href="http://blog.bitbucket.org">Blog</a></li>
      <li><a class="forums" href="http://groups.google.com/group/bitbucket-users">Forums</a></li>
    </ul>
    <a href="/" id="logo">Bitbucket by Atlassian</a>

    <div id="main-nav">
    
      <ul class="clearfix">
        <li><a href="/plans">Pricing &amp; signup</a></li>
        <li><a id="explore-link" href="/explore">Explore Bitbucket</a></li>
        <li class="active"><a href="/account/signin/?next=/account/signin/%3Fnext%3D/djekl/xbox-api/raw/master/application/controllers/session.php">Log in</a></li>
        

<li class="search-box">
  
    <form action="/repo/all">
      <input type="search" results="5" autosave="bitbucket-explore-search"
             name="name" id="searchbox"
             placeholder="owner/repo" />
  
  </form>
</li>

      </ul>
    
    </div>

  

    </div>
  </div>

    <div id="header-messages">
  
    
    
    
    
  

    
   </div>



    <div id="content">
      <div id="sign-in">
      

      
  

  <h1>Log in </h1>
  <div class="standard newform">
    
    <form action="/account/signin/" method="post"><div style='display:none'><input type='hidden' name='csrfmiddlewaretoken' value='5f55d9d7bb9caebabc0753d156d4e2b9' /></div>
      <input type="hidden" name="next" value="/djekl/xbox-api/raw/master/application/controllers/session.php" />
    
    
      
        <div class="required username">
          <label for="id_username">Username or email</label>
          <input type="text" id="id_username" name="username" autofocus="autofocus" />
        </div>
      
    
    
      <div class="password required">
        <label for="id_password">Password</label>
        <input type="password" id="id_password" name="password" />
        <p class="description"><a href="/account/password/reset/" tabindex="-1">Reset password</a></p>
      </div>
    
      <div class="submit">
        <input type="submit" value="Log in" name="submit" />
      </div>
    </form>
  </div>

  <div class="opensocial">
    

<form id="openid_form" action="/account/openid/redirect/" class="newform">
<div><input name="next" type="hidden" value="/djekl/xbox-api/raw/master/application/controllers/session.php" /></div>
  <label>OpenID provider</label>
  <ul class="badges">
    <li><a href="/account/openid/redirect/?openid_provider=https%3A%2F%2Fwww.google.com%2Faccounts%2Fo8%2Fid&next=/djekl/xbox-api/raw/master/application/controllers/session.php"
           title="Google">Google</a></li>
    <li><a href="/account/openid/redirect/?openid_provider=http%3A%2F%2Fyahoo.com%2F&next=/djekl/xbox-api/raw/master/application/controllers/session.php"
           title="Yahoo!">Yahoo!</a></li>
    <li><a href="#aol" title="AOL" data-url="http://openid.aol.com/{id}">AOL</a></li>
    <li><a href="#openid" title="OpenID" data-url="{id}">OpenID</a></li>
    <li><a href="#myopenid" title="MyOpenID" data-url="http://{id}.myopenid.com/">MyOpenID</a></li>
    <li><a href="#livejournal" title="LiveJournal" data-url="http://{id}.livejournal.com/">LiveJournal</a></li>
    <li><a href="#flickr" title="Flickr" data-url="http://flickr.com/{id}/">Flickr</a></li>
    <li><a href="#wordpress" title="WordPress" data-url="http://{id}.wordpress.com/">WordPress</a></li>
    <li><a href="#verisign" title="VeriSign" data-url="http://{id}.pip.verisignlabs.com/">VeriSign</a></li>
    <li><a href="#claimid" title="ClaimID" data-url="http://claimid.com/{id}">ClaimID</a></li>
  </ul>
  <div class="input-group">
    <div>
      <ul class="inputs">
        <li class="required" id="aol">
          <label for="aol-username">Username</label>
          <input type="text" id="aol-username" name="aol-username" />
        </li>
        <li class="required" id="openid">
          <label for="openid-url">OpenID URL</label>
          <input type="url" id="openid-url" name="openid-url" />
        </li>
        <li class="required" id="myopenid">
          <label for="myopenid-username">Username</label>
          <input type="text" id="myopenid-username" name="myopenid-username" />
        </li>
        <li class="required" id="livejournal">
          <label for="livejournal-username">Username</label>
          <input type="text" id="livejournal-username" name="livejournal-username" />
        </li>
        <li class="required" id="flickr">
          <label for="flickr-username">Username</label>
          <input type="text" id="flickr-username" name="flickr-username" />
        </li>
        <li class="required" id="wordpress">
          <label for="wordpress-username">Username</label>
          <input type="text" id="wordpress-username" name="wordpress-username" />
        </li>
        <li class="required" id="verisign">
          <label for="verisign-username">Username</label>
          <input type="text" id="verisign-username" name="verisign-username" />
        </li>
        <li class="required" id="claimid">
          <label for="claimid-username">Username</label>
          <input type="text" id="claimid-username" name="claimid-username" />
        </li>
      </ul>
    </div>
    <div class="submit">
      <input type="hidden" id="openid_provider" name="openid_provider" />
      <input type="hidden" id="openid_username" name="openid_username" />
      <input type="submit" id="openid_submit" class="primary" value="Log in" />
    </div>
  </div>
</form>

  </div>
  <p>Need an account? <a href="/plans">Sign up now!</a></p>
  <p class="show-open-id">Switch to <a href="#openid-signin">OpenID sign-in</a><noscript> (enable JavaScript to use this feature)</noscript></p>
  <p class="show-standard-signin">Switch to <a href="#standard-signin">standard sign-in</a></p>

      </div>
    </div>

  </div>

  <div id="footer">
    <ul id="footer-nav">
      <li>Copyright © 2012 <a href="http://atlassian.com">Atlassian</a></li>
      <li><a href="http://www.atlassian.com/hosted/terms.jsp">Terms of Service</a></li>
      <li><a href="http://www.atlassian.com/about/privacy.jsp">Privacy</a></li>
      <li><a href="//bitbucket.org/site/master/issues/new">Report a Bug to Bitbucket</a></li>
      <li><a href="http://confluence.atlassian.com/x/IYBGDQ">API</a></li>
      <li><a href="http://status.bitbucket.org/">Server Status</a></li>
    </ul>
    <ul id="social-nav">
      <li class="blog"><a href="http://blog.bitbucket.org">Bitbucket Blog</a></li>
      <li class="twitter"><a href="http://www.twitter.com/bitbucket">Twitter</a></li>
    </ul>
    <h5>We run</h5>
    <ul id="technologies">
      <li><a href="http://www.djangoproject.com/">Django 1.3.1</a></li>
      <li><a href="//bitbucket.org/jespern/django-piston/">Piston 0.3dev</a></li>
      <li><a href="http://git-scm.com/">Git 1.7.6</a></li>
      <li><a href="http://www.selenic.com/mercurial/">Hg 2.2.1</a></li>
      <li><a href="http://www.python.org">Python 2.7.3</a></li>
      <li>f9292b79c35c | bitbucket12</li>
    </ul>
  </div>

  <script src="https://dwz7u9t8u8usb.cloudfront.net/m/1a1b57f0564b/js/lib/global.js"></script>






  <script>
    BB.gaqPush(['_trackPageview']);
  
    BB.gaqPush(['atl._trackPageview']);

    

    

    (function () {
        var ga = document.createElement('script');
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.setAttribute('async', 'true');
        document.documentElement.firstChild.appendChild(ga);
    }());
  </script>

</body>
</html>

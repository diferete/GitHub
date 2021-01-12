


<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# githubog: http://ogp.me/ns/fb/githubog#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>jquery-maskmoney/jquery.maskMoney.js at master · plentz/jquery-maskmoney · GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png" />
    <link rel="logo" type="image/svg" href="https://github-media-downloads.s3.amazonaws.com/github-logo.svg" />
    <meta property="og:image" content="https://github.global.ssl.fastly.net/images/modules/logos_page/Octocat.png">
    <meta name="hostname" content="fe17.rs.github.com">
    <link rel="assets" href="https://github.global.ssl.fastly.net/">
    <link rel="xhr-socket" href="/_sockets" />
    
    


    <meta name="msapplication-TileImage" content="/windows-tile.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="selected-link" value="repo_source" data-pjax-transient />
    <meta content="collector.githubapp.com" name="octolytics-host" /><meta content="github" name="octolytics-app-id" />

    
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />

    <meta content="authenticity_token" name="csrf-param" />
<meta content="0l8aeQca/w6roFPrZ4RdnlbVbsl9hEwtcgDhRZ8aNjg=" name="csrf-token" />

    <link href="https://github.global.ssl.fastly.net/assets/github-7fa78c4fe7b5df12714028525116e8696e587c1f.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://github.global.ssl.fastly.net/assets/github2-27344f3be2108122f35c75101081563094420059.css" media="all" rel="stylesheet" type="text/css" />
    


      <script src="https://github.global.ssl.fastly.net/assets/frameworks-e8054ad804a1cf9e9849130fee5a4a5487b663ed.js" type="text/javascript"></script>
      <script src="https://github.global.ssl.fastly.net/assets/github-d3008e616d3b9f4112995c08deb6c468ad36fa91.js" type="text/javascript"></script>
      
      <meta http-equiv="x-pjax-version" content="c5bb64024e20327545b4552c2f528741">

        <link data-pjax-transient rel='permalink' href='/plentz/jquery-maskmoney/blob/1c80523cffc1081e45170bbf4c7fec7f7993539f/jquery.maskMoney.js'>
  <meta property="og:title" content="jquery-maskmoney"/>
  <meta property="og:type" content="githubog:gitrepository"/>
  <meta property="og:url" content="https://github.com/plentz/jquery-maskmoney"/>
  <meta property="og:image" content="https://github.global.ssl.fastly.net/images/gravatars/gravatar-user-420.png"/>
  <meta property="og:site_name" content="GitHub"/>
  <meta property="og:description" content="jquery-maskmoney - jQuery plugin to mask data entry in the input text in the form of money (currency)."/>

  <meta name="description" content="jquery-maskmoney - jQuery plugin to mask data entry in the input text in the form of money (currency)." />

  <meta content="4867" name="octolytics-dimension-user_id" /><meta content="plentz" name="octolytics-dimension-user_login" /><meta content="354843" name="octolytics-dimension-repository_id" /><meta content="plentz/jquery-maskmoney" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="354843" name="octolytics-dimension-repository_network_root_id" /><meta content="plentz/jquery-maskmoney" name="octolytics-dimension-repository_network_root_nwo" />
  <link href="https://github.com/plentz/jquery-maskmoney/commits/master.atom" rel="alternate" title="Recent Commits to jquery-maskmoney:master" type="application/atom+xml" />

  </head>


  <body class="logged_out page-blob windows vis-public env-production ">

    <div class="wrapper">
      
      
      


      
      <div class="header header-logged-out">
  <div class="container clearfix">

    <a class="header-logo-wordmark" href="https://github.com/">
      <span class="mega-octicon octicon-logo-github"></span>
    </a>

    <div class="header-actions">
        <a class="button primary" href="/signup">Sign up</a>
      <a class="button" href="/login?return_to=%2Fplentz%2Fjquery-maskmoney%2Fblob%2Fmaster%2Fjquery.maskMoney.js">Sign in</a>
    </div>

    <div class="command-bar js-command-bar  in-repository">


      <ul class="top-nav">
          <li class="explore"><a href="/explore">Explore</a></li>
        <li class="features"><a href="/features">Features</a></li>
          <li class="enterprise"><a href="https://enterprise.github.com/">Enterprise</a></li>
          <li class="blog"><a href="/blog">Blog</a></li>
      </ul>
        <form accept-charset="UTF-8" action="/search" class="command-bar-form" id="top_search_form" method="get">

<input type="text" data-hotkey="/ s" name="q" id="js-command-bar-field" placeholder="Search or type a command" tabindex="1" autocapitalize="off"
    
    
      data-repo="plentz/jquery-maskmoney"
      data-branch="master"
      data-sha="a3ecd2018efcc4773e6f5b01ba3f99ba9c378beb"
  >

    <input type="hidden" name="nwo" value="plentz/jquery-maskmoney" />

    <div class="select-menu js-menu-container js-select-menu search-context-select-menu">
      <span class="minibutton select-menu-button js-menu-target">
        <span class="js-select-button">This repository</span>
      </span>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container">
        <div class="select-menu-modal">

          <div class="select-menu-item js-navigation-item js-this-repository-navigation-item selected">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" class="js-search-this-repository" name="search_target" value="repository" checked="checked" />
            <div class="select-menu-item-text js-select-button-text">This repository</div>
          </div> <!-- /.select-menu-item -->

          <div class="select-menu-item js-navigation-item js-all-repositories-navigation-item">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" name="search_target" value="global" />
            <div class="select-menu-item-text js-select-button-text">All repositories</div>
          </div> <!-- /.select-menu-item -->

        </div>
      </div>
    </div>

  <span class="octicon help tooltipped downwards" title="Show command bar help">
    <span class="octicon octicon-question"></span>
  </span>


  <input type="hidden" name="ref" value="cmdform">

</form>
    </div>

  </div>
</div>


      


          <div class="site" itemscope itemtype="http://schema.org/WebPage">
    
    <div class="pagehead repohead instapaper_ignore readability-menu">
      <div class="container">
        

<ul class="pagehead-actions">


  <li>
  <a href="/login?return_to=%2Fplentz%2Fjquery-maskmoney"
  class="minibutton with-count js-toggler-target star-button entice tooltipped upwards "
  title="You must be signed in to use this feature" rel="nofollow">
  <span class="octicon octicon-star"></span>Star
</a>
<a class="social-count js-social-count" href="/plentz/jquery-maskmoney/stargazers">
  246
</a>

  </li>

    <li>
      <a href="/login?return_to=%2Fplentz%2Fjquery-maskmoney"
        class="minibutton with-count js-toggler-target fork-button entice tooltipped upwards"
        title="You must be signed in to fork a repository" rel="nofollow">
        <span class="octicon octicon-git-branch"></span>Fork
      </a>
      <a href="/plentz/jquery-maskmoney/network" class="social-count">
        135
      </a>
    </li>
</ul>

        <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
          <span class="repo-label"><span>public</span></span>
          <span class="mega-octicon octicon-repo"></span>
          <span class="author">
            <a href="/plentz" class="url fn" itemprop="url" rel="author"><span itemprop="title">plentz</span></a></span
          ><span class="repohead-name-divider">/</span><strong
          ><a href="/plentz/jquery-maskmoney" class="js-current-repository js-repo-home-link">jquery-maskmoney</a></strong>

          <span class="page-context-loader">
            <img alt="Octocat-spinner-32" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
          </span>

        </h1>
      </div><!-- /.container -->
    </div><!-- /.repohead -->

    <div class="container">

      <div class="repository-with-sidebar repo-container ">

        <div class="repository-sidebar">
            

<div class="repo-nav repo-nav-full js-repository-container-pjax js-octicon-loaders">
  <div class="repo-nav-contents">
    <ul class="repo-menu">
      <li class="tooltipped leftwards" title="Code">
        <a href="/plentz/jquery-maskmoney" aria-label="Code" class="js-selected-navigation-item selected" data-gotokey="c" data-pjax="true" data-selected-links="repo_source repo_downloads repo_commits repo_tags repo_branches /plentz/jquery-maskmoney">
          <span class="octicon octicon-code"></span> <span class="full-word">Code</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

        <li class="tooltipped leftwards" title="Issues">
          <a href="/plentz/jquery-maskmoney/issues" aria-label="Issues" class="js-selected-navigation-item js-disable-pjax" data-gotokey="i" data-selected-links="repo_issues /plentz/jquery-maskmoney/issues">
            <span class="octicon octicon-issue-opened"></span> <span class="full-word">Issues</span>
            <span class='counter'>25</span>
            <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>

      <li class="tooltipped leftwards" title="Pull Requests"><a href="/plentz/jquery-maskmoney/pulls" aria-label="Pull Requests" class="js-selected-navigation-item js-disable-pjax" data-gotokey="p" data-selected-links="repo_pulls /plentz/jquery-maskmoney/pulls">
            <span class="octicon octicon-git-pull-request"></span> <span class="full-word">Pull Requests</span>
            <span class='counter'>6</span>
            <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>


    </ul>
    <div class="repo-menu-separator"></div>
    <ul class="repo-menu">

      <li class="tooltipped leftwards" title="Pulse">
        <a href="/plentz/jquery-maskmoney/pulse" aria-label="Pulse" class="js-selected-navigation-item " data-pjax="true" data-selected-links="pulse /plentz/jquery-maskmoney/pulse">
          <span class="octicon octicon-pulse"></span> <span class="full-word">Pulse</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

      <li class="tooltipped leftwards" title="Graphs">
        <a href="/plentz/jquery-maskmoney/graphs" aria-label="Graphs" class="js-selected-navigation-item " data-pjax="true" data-selected-links="repo_graphs repo_contributors /plentz/jquery-maskmoney/graphs">
          <span class="octicon octicon-graph"></span> <span class="full-word">Graphs</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

      <li class="tooltipped leftwards" title="Network">
        <a href="/plentz/jquery-maskmoney/network" aria-label="Network" class="js-selected-navigation-item js-disable-pjax" data-selected-links="repo_network /plentz/jquery-maskmoney/network">
          <span class="octicon octicon-git-branch"></span> <span class="full-word">Network</span>
          <img alt="Octocat-spinner-32" class="mini-loader" height="16" src="https://github.global.ssl.fastly.net/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

    </ul>

  </div>
</div>

            <div class="only-with-full-nav">
              

  

<div class="clone-url open"
  data-protocol-type="http"
  data-url="/users/set_protocol?protocol_selector=http&amp;protocol_type=clone">
  <h3><strong>HTTPS</strong> clone URL</h3>

  <input type="text" class="clone js-url-field"
         value="https://github.com/plentz/jquery-maskmoney.git" readonly="readonly">

  <span class="js-zeroclipboard url-box-clippy minibutton zeroclipboard-button" data-clipboard-text="https://github.com/plentz/jquery-maskmoney.git" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
</div>

  

<div class="clone-url "
  data-protocol-type="subversion"
  data-url="/users/set_protocol?protocol_selector=subversion&amp;protocol_type=clone">
  <h3><strong>Subversion</strong> checkout URL</h3>

  <input type="text" class="clone js-url-field"
         value="https://github.com/plentz/jquery-maskmoney" readonly="readonly">

  <span class="js-zeroclipboard url-box-clippy minibutton zeroclipboard-button" data-clipboard-text="https://github.com/plentz/jquery-maskmoney" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
</div>



<p class="clone-options">You can clone with
    <a href="#" class="js-clone-selector" data-protocol="http">HTTPS</a>,
    <a href="#" class="js-clone-selector" data-protocol="subversion">Subversion</a>,
  and <a href="https://help.github.com/articles/which-remote-url-should-i-use">other methods.</a>
</p>


  <a href="http://windows.github.com" class="minibutton sidebar-button">
    <span class="octicon octicon-device-desktop"></span>
    Clone in Desktop
  </a>

                <a href="/plentz/jquery-maskmoney/archive/master.zip"
                   class="minibutton sidebar-button"
                   title="Download this repository as a zip file"
                   rel="nofollow">
                  <span class="octicon octicon-cloud-download"></span>
                  Download ZIP
                </a>
            </div>
        </div><!-- /.repository-sidebar -->

        <div id="js-repo-pjax-container" class="repository-content context-loader-container" data-pjax-container>
          


<!-- blob contrib key: blob_contributors:v21:a23e3b2f54db936e8f9bfe28d4ffbea4 -->
<!-- blob contrib frag key: views10/v8/blob_contributors:v21:a23e3b2f54db936e8f9bfe28d4ffbea4 -->

<p title="This is a placeholder element" class="js-history-link-replace hidden"></p>

<a href="/plentz/jquery-maskmoney/find/master" data-pjax data-hotkey="t" style="display:none">Show File Finder</a>

<div class="file-navigation">
  


<div class="select-menu js-menu-container js-select-menu" >
  <span class="minibutton select-menu-button js-menu-target" data-hotkey="w"
    data-master-branch="master"
    data-ref="master">
    <span class="octicon octicon-git-branch"></span>
    <i>branch:</i>
    <span class="js-select-button">master</span>
  </span>

  <div class="select-menu-modal-holder js-menu-content js-navigation-container" data-pjax>

    <div class="select-menu-modal">
      <div class="select-menu-header">
        <span class="select-menu-title">Switch branches/tags</span>
        <span class="octicon octicon-remove-close js-menu-close"></span>
      </div> <!-- /.select-menu-header -->

      <div class="select-menu-filters">
        <div class="select-menu-text-filter">
          <input type="text" id="context-commitish-filter-field" class="js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
        </div>
        <div class="select-menu-tabs">
          <ul>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="branches" class="js-select-menu-tab">Branches</a>
            </li>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="tags" class="js-select-menu-tab">Tags</a>
            </li>
          </ul>
        </div><!-- /.select-menu-tabs -->
      </div><!-- /.select-menu-filters -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="branches">

        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/1.x/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="1.x" data-skip-pjax="true" rel="nofollow" title="1.x">1.x</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/gh-pages/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="gh-pages" data-skip-pjax="true" rel="nofollow" title="gh-pages">gh-pages</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item selected">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/master/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="master" data-skip-pjax="true" rel="nofollow" title="master">master</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/no_dirty/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="no_dirty" data-skip-pjax="true" rel="nofollow" title="no_dirty">no_dirty</a>
            </div> <!-- /.select-menu-item -->
        </div>

          <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="tags">
        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v1.4.1/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.4.1" data-skip-pjax="true" rel="nofollow" title="v1.4.1">v1.4.1</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v1.4.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.4.0" data-skip-pjax="true" rel="nofollow" title="v1.4.0">v1.4.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v1.3.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.3.0" data-skip-pjax="true" rel="nofollow" title="v1.3.0">v1.3.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v1.2.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.2.0" data-skip-pjax="true" rel="nofollow" title="v1.2.0">v1.2.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v1.1.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.1.0" data-skip-pjax="true" rel="nofollow" title="v1.1.0">v1.1.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v1.0.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.0" data-skip-pjax="true" rel="nofollow" title="v1.0.0">v1.0.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v0.9.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.0" data-skip-pjax="true" rel="nofollow" title="v0.9.0">v0.9.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v0.5.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.5.0" data-skip-pjax="true" rel="nofollow" title="v0.5.0">v0.5.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v0.4.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.4.0" data-skip-pjax="true" rel="nofollow" title="v0.4.0">v0.4.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v0.3.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.3.0" data-skip-pjax="true" rel="nofollow" title="v0.3.0">v0.3.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/v0.1.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.1.0" data-skip-pjax="true" rel="nofollow" title="v0.1.0">v0.1.0</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/2.1.2/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="2.1.2" data-skip-pjax="true" rel="nofollow" title="2.1.2">2.1.2</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/2.0.1/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="2.0.1" data-skip-pjax="true" rel="nofollow" title="2.0.1">2.0.1</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/plentz/jquery-maskmoney/blob/2.0.0/jquery.maskMoney.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="2.0.0" data-skip-pjax="true" rel="nofollow" title="2.0.0">2.0.0</a>
            </div> <!-- /.select-menu-item -->
        </div>

        <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

    </div> <!-- /.select-menu-modal -->
  </div> <!-- /.select-menu-modal-holder -->
</div> <!-- /.select-menu -->

  <div class="breadcrumb">
    <span class='repo-root js-repo-root'><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/plentz/jquery-maskmoney" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">jquery-maskmoney</span></a></span></span><span class="separator"> / </span><strong class="final-path">jquery.maskMoney.js</strong> <span class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="jquery.maskMoney.js" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
  </div>
</div>


  
  <div class="commit file-history-tease">
    <img class="main-avatar" height="24" src="https://secure.gravatar.com/avatar/ae23b47de29112b26cccb1a1e51ad3e4?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
    <span class="author"><a href="/fjsj" rel="author">fjsj</a></span>
    <time class="js-relative-date" datetime="2013-05-08T15:40:11-07:00" title="2013-05-08 15:40:11">May 08, 2013</time>
    <div class="commit-title">
        <a href="/plentz/jquery-maskmoney/commit/c07abcd9eecf620f0fdc750a6f2172f16d75e3ed" class="message" data-pjax="true" title="Adapting to work with Zepto">Adapting to work with Zepto</a>
    </div>

    <div class="participation">
      <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>8</strong> contributors</a></p>
          <a class="avatar tooltipped downwards" title="plentz" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=plentz"><img height="20" src="https://secure.gravatar.com/avatar/6765ba9f85d8ac2d99725c347eadc023?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="bobeagan" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=bobeagan"><img height="20" src="https://secure.gravatar.com/avatar/b9153113291407d8122e070fac68ac41?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="pbalduino" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=pbalduino"><img height="20" src="https://secure.gravatar.com/avatar/4000105091ad77cd3f0838359265cdbc?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="gmoore" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=gmoore"><img height="20" src="https://secure.gravatar.com/avatar/d6406e63ffb970856077de6b55a3e358?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="fjsj" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=fjsj"><img height="20" src="https://secure.gravatar.com/avatar/ae23b47de29112b26cccb1a1e51ad3e4?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="cressie176" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=cressie176"><img height="20" src="https://secure.gravatar.com/avatar/d545d82da4fdd88773aa14552be5a386?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="crbdigo" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=crbdigo"><img height="20" src="https://secure.gravatar.com/avatar/f2fb3a3cd11b8ee82e4b5793390084da?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="xtream" href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js?author=xtream"><img height="20" src="https://secure.gravatar.com/avatar/a0e2af5a8763042d2cb20540de3a633f?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /></a>


    </div>
    <div id="blob_contributors_box" style="display:none">
      <h2 class="facebox-header">Users who have contributed to this file</h2>
      <ul class="facebox-user-list">
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/6765ba9f85d8ac2d99725c347eadc023?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/plentz">plentz</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/b9153113291407d8122e070fac68ac41?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/bobeagan">bobeagan</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/4000105091ad77cd3f0838359265cdbc?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/pbalduino">pbalduino</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/d6406e63ffb970856077de6b55a3e358?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/gmoore">gmoore</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/ae23b47de29112b26cccb1a1e51ad3e4?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/fjsj">fjsj</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/d545d82da4fdd88773aa14552be5a386?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/cressie176">cressie176</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/f2fb3a3cd11b8ee82e4b5793390084da?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/crbdigo">crbdigo</a>
        </li>
        <li class="facebox-user-list-item">
          <img height="24" src="https://secure.gravatar.com/avatar/a0e2af5a8763042d2cb20540de3a633f?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/xtream">xtream</a>
        </li>
      </ul>
    </div>
  </div>


<div id="files" class="bubble">
  <div class="file">
    <div class="meta">
      <div class="info">
        <span class="icon"><b class="octicon octicon-file-text"></b></span>
        <span class="mode" title="File Mode">file</span>
          <span>373 lines (328 sloc)</span>
        <span>11.04 kb</span>
      </div>
      <div class="actions">
        <div class="button-group">
              <a class="minibutton js-entice" href=""
                 data-entice="You must be signed in to make or propose changes">Edit</a>
          <a href="/plentz/jquery-maskmoney/raw/master/jquery.maskMoney.js" class="button minibutton " id="raw-url">Raw</a>
            <a href="/plentz/jquery-maskmoney/blame/master/jquery.maskMoney.js" class="button minibutton ">Blame</a>
          <a href="/plentz/jquery-maskmoney/commits/master/jquery.maskMoney.js" class="button minibutton " rel="nofollow">History</a>
        </div><!-- /.button-group -->
            <a class="minibutton danger empty-icon js-entice" href=""
               data-entice="You must be signed in and on a branch to make or propose changes">
            Delete
          </a>
      </div><!-- /.actions -->

    </div>
        <div class="blob-wrapper data type-javascript js-blob-data">
      <table class="file-code file-diff">
        <tr class="file-code-line">
          <td class="blob-line-nums">
            <span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>
<span id="L80" rel="#L80">80</span>
<span id="L81" rel="#L81">81</span>
<span id="L82" rel="#L82">82</span>
<span id="L83" rel="#L83">83</span>
<span id="L84" rel="#L84">84</span>
<span id="L85" rel="#L85">85</span>
<span id="L86" rel="#L86">86</span>
<span id="L87" rel="#L87">87</span>
<span id="L88" rel="#L88">88</span>
<span id="L89" rel="#L89">89</span>
<span id="L90" rel="#L90">90</span>
<span id="L91" rel="#L91">91</span>
<span id="L92" rel="#L92">92</span>
<span id="L93" rel="#L93">93</span>
<span id="L94" rel="#L94">94</span>
<span id="L95" rel="#L95">95</span>
<span id="L96" rel="#L96">96</span>
<span id="L97" rel="#L97">97</span>
<span id="L98" rel="#L98">98</span>
<span id="L99" rel="#L99">99</span>
<span id="L100" rel="#L100">100</span>
<span id="L101" rel="#L101">101</span>
<span id="L102" rel="#L102">102</span>
<span id="L103" rel="#L103">103</span>
<span id="L104" rel="#L104">104</span>
<span id="L105" rel="#L105">105</span>
<span id="L106" rel="#L106">106</span>
<span id="L107" rel="#L107">107</span>
<span id="L108" rel="#L108">108</span>
<span id="L109" rel="#L109">109</span>
<span id="L110" rel="#L110">110</span>
<span id="L111" rel="#L111">111</span>
<span id="L112" rel="#L112">112</span>
<span id="L113" rel="#L113">113</span>
<span id="L114" rel="#L114">114</span>
<span id="L115" rel="#L115">115</span>
<span id="L116" rel="#L116">116</span>
<span id="L117" rel="#L117">117</span>
<span id="L118" rel="#L118">118</span>
<span id="L119" rel="#L119">119</span>
<span id="L120" rel="#L120">120</span>
<span id="L121" rel="#L121">121</span>
<span id="L122" rel="#L122">122</span>
<span id="L123" rel="#L123">123</span>
<span id="L124" rel="#L124">124</span>
<span id="L125" rel="#L125">125</span>
<span id="L126" rel="#L126">126</span>
<span id="L127" rel="#L127">127</span>
<span id="L128" rel="#L128">128</span>
<span id="L129" rel="#L129">129</span>
<span id="L130" rel="#L130">130</span>
<span id="L131" rel="#L131">131</span>
<span id="L132" rel="#L132">132</span>
<span id="L133" rel="#L133">133</span>
<span id="L134" rel="#L134">134</span>
<span id="L135" rel="#L135">135</span>
<span id="L136" rel="#L136">136</span>
<span id="L137" rel="#L137">137</span>
<span id="L138" rel="#L138">138</span>
<span id="L139" rel="#L139">139</span>
<span id="L140" rel="#L140">140</span>
<span id="L141" rel="#L141">141</span>
<span id="L142" rel="#L142">142</span>
<span id="L143" rel="#L143">143</span>
<span id="L144" rel="#L144">144</span>
<span id="L145" rel="#L145">145</span>
<span id="L146" rel="#L146">146</span>
<span id="L147" rel="#L147">147</span>
<span id="L148" rel="#L148">148</span>
<span id="L149" rel="#L149">149</span>
<span id="L150" rel="#L150">150</span>
<span id="L151" rel="#L151">151</span>
<span id="L152" rel="#L152">152</span>
<span id="L153" rel="#L153">153</span>
<span id="L154" rel="#L154">154</span>
<span id="L155" rel="#L155">155</span>
<span id="L156" rel="#L156">156</span>
<span id="L157" rel="#L157">157</span>
<span id="L158" rel="#L158">158</span>
<span id="L159" rel="#L159">159</span>
<span id="L160" rel="#L160">160</span>
<span id="L161" rel="#L161">161</span>
<span id="L162" rel="#L162">162</span>
<span id="L163" rel="#L163">163</span>
<span id="L164" rel="#L164">164</span>
<span id="L165" rel="#L165">165</span>
<span id="L166" rel="#L166">166</span>
<span id="L167" rel="#L167">167</span>
<span id="L168" rel="#L168">168</span>
<span id="L169" rel="#L169">169</span>
<span id="L170" rel="#L170">170</span>
<span id="L171" rel="#L171">171</span>
<span id="L172" rel="#L172">172</span>
<span id="L173" rel="#L173">173</span>
<span id="L174" rel="#L174">174</span>
<span id="L175" rel="#L175">175</span>
<span id="L176" rel="#L176">176</span>
<span id="L177" rel="#L177">177</span>
<span id="L178" rel="#L178">178</span>
<span id="L179" rel="#L179">179</span>
<span id="L180" rel="#L180">180</span>
<span id="L181" rel="#L181">181</span>
<span id="L182" rel="#L182">182</span>
<span id="L183" rel="#L183">183</span>
<span id="L184" rel="#L184">184</span>
<span id="L185" rel="#L185">185</span>
<span id="L186" rel="#L186">186</span>
<span id="L187" rel="#L187">187</span>
<span id="L188" rel="#L188">188</span>
<span id="L189" rel="#L189">189</span>
<span id="L190" rel="#L190">190</span>
<span id="L191" rel="#L191">191</span>
<span id="L192" rel="#L192">192</span>
<span id="L193" rel="#L193">193</span>
<span id="L194" rel="#L194">194</span>
<span id="L195" rel="#L195">195</span>
<span id="L196" rel="#L196">196</span>
<span id="L197" rel="#L197">197</span>
<span id="L198" rel="#L198">198</span>
<span id="L199" rel="#L199">199</span>
<span id="L200" rel="#L200">200</span>
<span id="L201" rel="#L201">201</span>
<span id="L202" rel="#L202">202</span>
<span id="L203" rel="#L203">203</span>
<span id="L204" rel="#L204">204</span>
<span id="L205" rel="#L205">205</span>
<span id="L206" rel="#L206">206</span>
<span id="L207" rel="#L207">207</span>
<span id="L208" rel="#L208">208</span>
<span id="L209" rel="#L209">209</span>
<span id="L210" rel="#L210">210</span>
<span id="L211" rel="#L211">211</span>
<span id="L212" rel="#L212">212</span>
<span id="L213" rel="#L213">213</span>
<span id="L214" rel="#L214">214</span>
<span id="L215" rel="#L215">215</span>
<span id="L216" rel="#L216">216</span>
<span id="L217" rel="#L217">217</span>
<span id="L218" rel="#L218">218</span>
<span id="L219" rel="#L219">219</span>
<span id="L220" rel="#L220">220</span>
<span id="L221" rel="#L221">221</span>
<span id="L222" rel="#L222">222</span>
<span id="L223" rel="#L223">223</span>
<span id="L224" rel="#L224">224</span>
<span id="L225" rel="#L225">225</span>
<span id="L226" rel="#L226">226</span>
<span id="L227" rel="#L227">227</span>
<span id="L228" rel="#L228">228</span>
<span id="L229" rel="#L229">229</span>
<span id="L230" rel="#L230">230</span>
<span id="L231" rel="#L231">231</span>
<span id="L232" rel="#L232">232</span>
<span id="L233" rel="#L233">233</span>
<span id="L234" rel="#L234">234</span>
<span id="L235" rel="#L235">235</span>
<span id="L236" rel="#L236">236</span>
<span id="L237" rel="#L237">237</span>
<span id="L238" rel="#L238">238</span>
<span id="L239" rel="#L239">239</span>
<span id="L240" rel="#L240">240</span>
<span id="L241" rel="#L241">241</span>
<span id="L242" rel="#L242">242</span>
<span id="L243" rel="#L243">243</span>
<span id="L244" rel="#L244">244</span>
<span id="L245" rel="#L245">245</span>
<span id="L246" rel="#L246">246</span>
<span id="L247" rel="#L247">247</span>
<span id="L248" rel="#L248">248</span>
<span id="L249" rel="#L249">249</span>
<span id="L250" rel="#L250">250</span>
<span id="L251" rel="#L251">251</span>
<span id="L252" rel="#L252">252</span>
<span id="L253" rel="#L253">253</span>
<span id="L254" rel="#L254">254</span>
<span id="L255" rel="#L255">255</span>
<span id="L256" rel="#L256">256</span>
<span id="L257" rel="#L257">257</span>
<span id="L258" rel="#L258">258</span>
<span id="L259" rel="#L259">259</span>
<span id="L260" rel="#L260">260</span>
<span id="L261" rel="#L261">261</span>
<span id="L262" rel="#L262">262</span>
<span id="L263" rel="#L263">263</span>
<span id="L264" rel="#L264">264</span>
<span id="L265" rel="#L265">265</span>
<span id="L266" rel="#L266">266</span>
<span id="L267" rel="#L267">267</span>
<span id="L268" rel="#L268">268</span>
<span id="L269" rel="#L269">269</span>
<span id="L270" rel="#L270">270</span>
<span id="L271" rel="#L271">271</span>
<span id="L272" rel="#L272">272</span>
<span id="L273" rel="#L273">273</span>
<span id="L274" rel="#L274">274</span>
<span id="L275" rel="#L275">275</span>
<span id="L276" rel="#L276">276</span>
<span id="L277" rel="#L277">277</span>
<span id="L278" rel="#L278">278</span>
<span id="L279" rel="#L279">279</span>
<span id="L280" rel="#L280">280</span>
<span id="L281" rel="#L281">281</span>
<span id="L282" rel="#L282">282</span>
<span id="L283" rel="#L283">283</span>
<span id="L284" rel="#L284">284</span>
<span id="L285" rel="#L285">285</span>
<span id="L286" rel="#L286">286</span>
<span id="L287" rel="#L287">287</span>
<span id="L288" rel="#L288">288</span>
<span id="L289" rel="#L289">289</span>
<span id="L290" rel="#L290">290</span>
<span id="L291" rel="#L291">291</span>
<span id="L292" rel="#L292">292</span>
<span id="L293" rel="#L293">293</span>
<span id="L294" rel="#L294">294</span>
<span id="L295" rel="#L295">295</span>
<span id="L296" rel="#L296">296</span>
<span id="L297" rel="#L297">297</span>
<span id="L298" rel="#L298">298</span>
<span id="L299" rel="#L299">299</span>
<span id="L300" rel="#L300">300</span>
<span id="L301" rel="#L301">301</span>
<span id="L302" rel="#L302">302</span>
<span id="L303" rel="#L303">303</span>
<span id="L304" rel="#L304">304</span>
<span id="L305" rel="#L305">305</span>
<span id="L306" rel="#L306">306</span>
<span id="L307" rel="#L307">307</span>
<span id="L308" rel="#L308">308</span>
<span id="L309" rel="#L309">309</span>
<span id="L310" rel="#L310">310</span>
<span id="L311" rel="#L311">311</span>
<span id="L312" rel="#L312">312</span>
<span id="L313" rel="#L313">313</span>
<span id="L314" rel="#L314">314</span>
<span id="L315" rel="#L315">315</span>
<span id="L316" rel="#L316">316</span>
<span id="L317" rel="#L317">317</span>
<span id="L318" rel="#L318">318</span>
<span id="L319" rel="#L319">319</span>
<span id="L320" rel="#L320">320</span>
<span id="L321" rel="#L321">321</span>
<span id="L322" rel="#L322">322</span>
<span id="L323" rel="#L323">323</span>
<span id="L324" rel="#L324">324</span>
<span id="L325" rel="#L325">325</span>
<span id="L326" rel="#L326">326</span>
<span id="L327" rel="#L327">327</span>
<span id="L328" rel="#L328">328</span>
<span id="L329" rel="#L329">329</span>
<span id="L330" rel="#L330">330</span>
<span id="L331" rel="#L331">331</span>
<span id="L332" rel="#L332">332</span>
<span id="L333" rel="#L333">333</span>
<span id="L334" rel="#L334">334</span>
<span id="L335" rel="#L335">335</span>
<span id="L336" rel="#L336">336</span>
<span id="L337" rel="#L337">337</span>
<span id="L338" rel="#L338">338</span>
<span id="L339" rel="#L339">339</span>
<span id="L340" rel="#L340">340</span>
<span id="L341" rel="#L341">341</span>
<span id="L342" rel="#L342">342</span>
<span id="L343" rel="#L343">343</span>
<span id="L344" rel="#L344">344</span>
<span id="L345" rel="#L345">345</span>
<span id="L346" rel="#L346">346</span>
<span id="L347" rel="#L347">347</span>
<span id="L348" rel="#L348">348</span>
<span id="L349" rel="#L349">349</span>
<span id="L350" rel="#L350">350</span>
<span id="L351" rel="#L351">351</span>
<span id="L352" rel="#L352">352</span>
<span id="L353" rel="#L353">353</span>
<span id="L354" rel="#L354">354</span>
<span id="L355" rel="#L355">355</span>
<span id="L356" rel="#L356">356</span>
<span id="L357" rel="#L357">357</span>
<span id="L358" rel="#L358">358</span>
<span id="L359" rel="#L359">359</span>
<span id="L360" rel="#L360">360</span>
<span id="L361" rel="#L361">361</span>
<span id="L362" rel="#L362">362</span>
<span id="L363" rel="#L363">363</span>
<span id="L364" rel="#L364">364</span>
<span id="L365" rel="#L365">365</span>
<span id="L366" rel="#L366">366</span>
<span id="L367" rel="#L367">367</span>
<span id="L368" rel="#L368">368</span>
<span id="L369" rel="#L369">369</span>
<span id="L370" rel="#L370">370</span>
<span id="L371" rel="#L371">371</span>
<span id="L372" rel="#L372">372</span>

          </td>
          <td class="blob-line-code">
                  <div class="highlight"><pre><div class='line' id='LC1'><span class="cm">/*</span></div><div class='line' id='LC2'><span class="cm">* maskMoney plugin for jQuery</span></div><div class='line' id='LC3'><span class="cm">* http://plentz.github.com/jquery-maskmoney/</span></div><div class='line' id='LC4'><span class="cm">* version: 2.1.2</span></div><div class='line' id='LC5'><span class="cm">* Licensed under the MIT license</span></div><div class='line' id='LC6'><span class="cm">*/</span></div><div class='line' id='LC7'><span class="p">;(</span><span class="kd">function</span><span class="p">(</span><span class="nx">$</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC8'>	<span class="k">if</span><span class="p">(</span><span class="o">!</span><span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">){</span></div><div class='line' id='LC9'>		<span class="nx">$</span><span class="p">.</span><span class="nx">browser</span> <span class="o">=</span> <span class="p">{};</span></div><div class='line' id='LC10'>		<span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">mozilla</span> <span class="o">=</span> <span class="sr">/mozilla/</span><span class="p">.</span><span class="nx">test</span><span class="p">(</span><span class="nx">navigator</span><span class="p">.</span><span class="nx">userAgent</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">())</span> <span class="o">&amp;&amp;</span> <span class="o">!</span><span class="sr">/webkit/</span><span class="p">.</span><span class="nx">test</span><span class="p">(</span><span class="nx">navigator</span><span class="p">.</span><span class="nx">userAgent</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">());</span></div><div class='line' id='LC11'>		<span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">webkit</span> <span class="o">=</span> <span class="sr">/webkit/</span><span class="p">.</span><span class="nx">test</span><span class="p">(</span><span class="nx">navigator</span><span class="p">.</span><span class="nx">userAgent</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">());</span></div><div class='line' id='LC12'>		<span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">opera</span> <span class="o">=</span> <span class="sr">/opera/</span><span class="p">.</span><span class="nx">test</span><span class="p">(</span><span class="nx">navigator</span><span class="p">.</span><span class="nx">userAgent</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">());</span></div><div class='line' id='LC13'>		<span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">msie</span> <span class="o">=</span> <span class="sr">/msie/</span><span class="p">.</span><span class="nx">test</span><span class="p">(</span><span class="nx">navigator</span><span class="p">.</span><span class="nx">userAgent</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">());</span></div><div class='line' id='LC14'>	<span class="p">}</span></div><div class='line' id='LC15'><br/></div><div class='line' id='LC16'>	<span class="kd">var</span> <span class="nx">methods</span> <span class="o">=</span> <span class="p">{</span></div><div class='line' id='LC17'>		<span class="nx">destroy</span> <span class="o">:</span> <span class="kd">function</span><span class="p">(){</span></div><div class='line' id='LC18'>			<span class="kd">var</span> <span class="nx">input</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">);</span></div><div class='line' id='LC19'>			<span class="nx">input</span><span class="p">.</span><span class="nx">unbind</span><span class="p">(</span><span class="s1">&#39;.maskMoney&#39;</span><span class="p">);</span></div><div class='line' id='LC20'><br/></div><div class='line' id='LC21'>			<span class="k">if</span> <span class="p">(</span><span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">msie</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC22'>				<span class="k">this</span><span class="p">.</span><span class="nx">onpaste</span> <span class="o">=</span> <span class="kc">null</span><span class="p">;</span></div><div class='line' id='LC23'>			<span class="p">}</span></div><div class='line' id='LC24'>			<span class="k">return</span> <span class="k">this</span><span class="p">;</span></div><div class='line' id='LC25'>		<span class="p">},</span></div><div class='line' id='LC26'><br/></div><div class='line' id='LC27'>		<span class="nx">mask</span> <span class="o">:</span> <span class="kd">function</span><span class="p">(){</span></div><div class='line' id='LC28'>			<span class="k">return</span> <span class="k">this</span><span class="p">.</span><span class="nx">trigger</span><span class="p">(</span><span class="s1">&#39;mask&#39;</span><span class="p">);</span></div><div class='line' id='LC29'>		<span class="p">},</span></div><div class='line' id='LC30'><br/></div><div class='line' id='LC31'>		<span class="nx">init</span> <span class="o">:</span> <span class="kd">function</span><span class="p">(</span><span class="nx">settings</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC32'>			<span class="nx">settings</span> <span class="o">=</span> <span class="nx">$</span><span class="p">.</span><span class="nx">extend</span><span class="p">({</span></div><div class='line' id='LC33'>				<span class="nx">symbol</span><span class="o">:</span> <span class="s1">&#39;&#39;</span><span class="p">,</span></div><div class='line' id='LC34'>				<span class="nx">symbolStay</span><span class="o">:</span> <span class="kc">false</span><span class="p">,</span></div><div class='line' id='LC35'>				<span class="nx">thousands</span><span class="o">:</span> <span class="s1">&#39;,&#39;</span><span class="p">,</span></div><div class='line' id='LC36'>				<span class="nx">decimal</span><span class="o">:</span> <span class="s1">&#39;.&#39;</span><span class="p">,</span></div><div class='line' id='LC37'>				<span class="nx">precision</span><span class="o">:</span> <span class="mi">2</span><span class="p">,</span></div><div class='line' id='LC38'>				<span class="nx">defaultZero</span><span class="o">:</span> <span class="kc">true</span><span class="p">,</span></div><div class='line' id='LC39'>				<span class="nx">allowZero</span><span class="o">:</span> <span class="kc">false</span><span class="p">,</span></div><div class='line' id='LC40'>				<span class="nx">allowNegative</span><span class="o">:</span> <span class="kc">false</span></div><div class='line' id='LC41'>			<span class="p">},</span> <span class="nx">settings</span><span class="p">);</span></div><div class='line' id='LC42'><br/></div><div class='line' id='LC43'>			<span class="k">return</span> <span class="k">this</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span><span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC44'>				<span class="kd">var</span> <span class="nx">input</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">);</span></div><div class='line' id='LC45'>				<span class="kd">var</span> <span class="nx">dirty</span> <span class="o">=</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC46'><br/></div><div class='line' id='LC47'>				<span class="kd">function</span> <span class="nx">markAsDirty</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC48'>					<span class="nx">dirty</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC49'>				<span class="p">}</span></div><div class='line' id='LC50'><br/></div><div class='line' id='LC51'>				<span class="kd">function</span> <span class="nx">clearDirt</span><span class="p">(){</span></div><div class='line' id='LC52'>					<span class="nx">dirty</span> <span class="o">=</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC53'>				<span class="p">}</span></div><div class='line' id='LC54'><br/></div><div class='line' id='LC55'>				<span class="kd">function</span> <span class="nx">keypressEvent</span><span class="p">(</span><span class="nx">e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC56'>					<span class="nx">e</span> <span class="o">=</span> <span class="nx">e</span> <span class="o">||</span> <span class="nb">window</span><span class="p">.</span><span class="nx">event</span><span class="p">;</span></div><div class='line' id='LC57'>					<span class="kd">var</span> <span class="nx">k</span> <span class="o">=</span> <span class="nx">e</span><span class="p">.</span><span class="nx">which</span> <span class="o">||</span> <span class="nx">e</span><span class="p">.</span><span class="nx">charCode</span> <span class="o">||</span> <span class="nx">e</span><span class="p">.</span><span class="nx">keyCode</span><span class="p">;</span></div><div class='line' id='LC58'>					<span class="k">if</span> <span class="p">(</span><span class="nx">k</span> <span class="o">==</span> <span class="kc">undefined</span><span class="p">)</span> <span class="k">return</span> <span class="kc">false</span><span class="p">;</span> <span class="c1">//needed to handle an IE &quot;special&quot; event</span></div><div class='line' id='LC59'>					<span class="k">if</span> <span class="p">(</span><span class="nx">k</span> <span class="o">&lt;</span> <span class="mi">48</span> <span class="o">||</span> <span class="nx">k</span> <span class="o">&gt;</span> <span class="mi">57</span><span class="p">)</span> <span class="p">{</span> <span class="c1">// any key except the numbers 0-9</span></div><div class='line' id='LC60'>						<span class="k">if</span> <span class="p">(</span><span class="nx">k</span> <span class="o">==</span> <span class="mi">45</span><span class="p">)</span> <span class="p">{</span> <span class="c1">// -(minus) key</span></div><div class='line' id='LC61'>							<span class="nx">markAsDirty</span><span class="p">();</span></div><div class='line' id='LC62'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">changeSign</span><span class="p">(</span><span class="nx">input</span><span class="p">));</span></div><div class='line' id='LC63'>							<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC64'>						<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">k</span> <span class="o">==</span> <span class="mi">43</span><span class="p">)</span> <span class="p">{</span> <span class="c1">// +(plus) key</span></div><div class='line' id='LC65'>							<span class="nx">markAsDirty</span><span class="p">();</span></div><div class='line' id='LC66'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">().</span><span class="nx">replace</span><span class="p">(</span><span class="s1">&#39;-&#39;</span><span class="p">,</span><span class="s1">&#39;&#39;</span><span class="p">));</span></div><div class='line' id='LC67'>							<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC68'>						<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">k</span> <span class="o">==</span> <span class="mi">13</span> <span class="o">||</span> <span class="nx">k</span> <span class="o">==</span> <span class="mi">9</span><span class="p">)</span> <span class="p">{</span> <span class="c1">// enter key or tab key</span></div><div class='line' id='LC69'>							<span class="k">if</span><span class="p">(</span><span class="nx">dirty</span><span class="p">){</span></div><div class='line' id='LC70'>								<span class="nx">clearDirt</span><span class="p">();</span></div><div class='line' id='LC71'>								<span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">).</span><span class="nx">change</span><span class="p">();</span></div><div class='line' id='LC72'>							<span class="p">}</span></div><div class='line' id='LC73'>							<span class="k">return</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC74'>						<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">mozilla</span> <span class="o">&amp;&amp;</span> <span class="p">(</span><span class="nx">k</span> <span class="o">==</span> <span class="mi">37</span> <span class="o">||</span> <span class="nx">k</span> <span class="o">==</span> <span class="mi">39</span><span class="p">)</span> <span class="o">&amp;&amp;</span> <span class="nx">e</span><span class="p">.</span><span class="nx">charCode</span> <span class="o">==</span> <span class="mi">0</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC75'>							<span class="c1">// needed for left arrow key or right arrow key with firefox</span></div><div class='line' id='LC76'>							<span class="c1">// the charCode part is to avoid allowing &#39;%&#39;(e.charCode 0, e.keyCode 37)</span></div><div class='line' id='LC77'>							<span class="k">return</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC78'>						<span class="p">}</span> <span class="k">else</span> <span class="p">{</span> <span class="c1">// any other key with keycode less than 48 and greater than 57</span></div><div class='line' id='LC79'>							<span class="nx">preventDefault</span><span class="p">(</span><span class="nx">e</span><span class="p">);</span></div><div class='line' id='LC80'>							<span class="k">return</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC81'>						<span class="p">}</span></div><div class='line' id='LC82'>					<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">canInputMoreNumbers</span><span class="p">(</span><span class="nx">input</span><span class="p">))</span> <span class="p">{</span></div><div class='line' id='LC83'>						<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC84'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC85'>						<span class="nx">preventDefault</span><span class="p">(</span><span class="nx">e</span><span class="p">);</span></div><div class='line' id='LC86'><br/></div><div class='line' id='LC87'>						<span class="kd">var</span> <span class="nx">key</span> <span class="o">=</span> <span class="nb">String</span><span class="p">.</span><span class="nx">fromCharCode</span><span class="p">(</span><span class="nx">k</span><span class="p">);</span></div><div class='line' id='LC88'>						<span class="kd">var</span> <span class="nx">x</span> <span class="o">=</span> <span class="nx">input</span><span class="p">.</span><span class="nx">get</span><span class="p">(</span><span class="mi">0</span><span class="p">);</span></div><div class='line' id='LC89'>						<span class="kd">var</span> <span class="nx">selection</span> <span class="o">=</span> <span class="nx">getInputSelection</span><span class="p">(</span><span class="nx">x</span><span class="p">);</span></div><div class='line' id='LC90'>						<span class="kd">var</span> <span class="nx">startPos</span> <span class="o">=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">start</span><span class="p">;</span></div><div class='line' id='LC91'>						<span class="kd">var</span> <span class="nx">endPos</span> <span class="o">=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">end</span><span class="p">;</span></div><div class='line' id='LC92'>						<span class="nx">x</span><span class="p">.</span><span class="nx">value</span> <span class="o">=</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">)</span> <span class="o">+</span> <span class="nx">key</span> <span class="o">+</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="nx">endPos</span><span class="p">,</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span><span class="p">);</span></div><div class='line' id='LC93'>						<span class="nx">maskAndPosition</span><span class="p">(</span><span class="nx">x</span><span class="p">,</span> <span class="nx">startPos</span> <span class="o">+</span> <span class="mi">1</span><span class="p">);</span></div><div class='line' id='LC94'>						<span class="nx">markAsDirty</span><span class="p">();</span></div><div class='line' id='LC95'>						<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC96'>					<span class="p">}</span></div><div class='line' id='LC97'>				<span class="p">}</span></div><div class='line' id='LC98'><br/></div><div class='line' id='LC99'>				<span class="kd">function</span> <span class="nx">canInputMoreNumbers</span><span class="p">(</span><span class="nx">element</span><span class="p">){</span></div><div class='line' id='LC100'>					<span class="kd">var</span> <span class="nx">reachedMaxLenght</span> <span class="o">=</span> <span class="p">(</span><span class="nx">element</span><span class="p">.</span><span class="nx">val</span><span class="p">().</span><span class="nx">length</span> <span class="o">&gt;=</span> <span class="nx">element</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s1">&#39;maxlength&#39;</span><span class="p">)</span> <span class="o">&amp;&amp;</span> <span class="nx">element</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s1">&#39;maxlength&#39;</span><span class="p">)</span> <span class="o">&gt;=</span> <span class="mi">0</span><span class="p">);</span></div><div class='line' id='LC101'>					<span class="kd">var</span> <span class="nx">selection</span> <span class="o">=</span> <span class="nx">getInputSelection</span><span class="p">(</span><span class="nx">element</span><span class="p">.</span><span class="nx">get</span><span class="p">(</span><span class="mi">0</span><span class="p">));</span></div><div class='line' id='LC102'>					<span class="kd">var</span> <span class="nx">start</span> <span class="o">=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">start</span><span class="p">;</span></div><div class='line' id='LC103'>					<span class="kd">var</span> <span class="nx">end</span> <span class="o">=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">end</span><span class="p">;</span></div><div class='line' id='LC104'>					<span class="kd">var</span> <span class="nx">hasNumberSelected</span> <span class="o">=</span> <span class="p">(</span><span class="nx">selection</span><span class="p">.</span><span class="nx">start</span> <span class="o">!=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">end</span> <span class="o">&amp;&amp;</span> <span class="nx">element</span><span class="p">.</span><span class="nx">val</span><span class="p">().</span><span class="nx">substring</span><span class="p">(</span><span class="nx">start</span><span class="p">,</span><span class="nx">end</span><span class="p">).</span><span class="nx">match</span><span class="p">(</span><span class="sr">/\d/</span><span class="p">))</span><span class="o">?</span> <span class="kc">true</span> <span class="o">:</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC105'>					<span class="k">return</span> <span class="nx">reachedMaxLenght</span> <span class="o">&amp;&amp;</span> <span class="o">!</span><span class="nx">hasNumberSelected</span><span class="p">;</span></div><div class='line' id='LC106'>				<span class="p">}</span></div><div class='line' id='LC107'><br/></div><div class='line' id='LC108'>				<span class="kd">function</span> <span class="nx">keydownEvent</span><span class="p">(</span><span class="nx">e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC109'>					<span class="nx">e</span> <span class="o">=</span> <span class="nx">e</span><span class="o">||</span><span class="nb">window</span><span class="p">.</span><span class="nx">event</span><span class="p">;</span></div><div class='line' id='LC110'>					<span class="kd">var</span> <span class="nx">k</span> <span class="o">=</span> <span class="nx">e</span><span class="p">.</span><span class="nx">which</span> <span class="o">||</span> <span class="nx">e</span><span class="p">.</span><span class="nx">charCode</span> <span class="o">||</span> <span class="nx">e</span><span class="p">.</span><span class="nx">keyCode</span><span class="p">;</span></div><div class='line' id='LC111'>					<span class="k">if</span> <span class="p">(</span><span class="nx">k</span> <span class="o">==</span> <span class="kc">undefined</span><span class="p">)</span> <span class="k">return</span> <span class="kc">false</span><span class="p">;</span> <span class="c1">//needed to handle an IE &quot;special&quot; event</span></div><div class='line' id='LC112'><br/></div><div class='line' id='LC113'>					<span class="kd">var</span> <span class="nx">x</span> <span class="o">=</span> <span class="nx">input</span><span class="p">.</span><span class="nx">get</span><span class="p">(</span><span class="mi">0</span><span class="p">);</span></div><div class='line' id='LC114'>					<span class="kd">var</span> <span class="nx">selection</span> <span class="o">=</span> <span class="nx">getInputSelection</span><span class="p">(</span><span class="nx">x</span><span class="p">);</span></div><div class='line' id='LC115'>					<span class="kd">var</span> <span class="nx">startPos</span> <span class="o">=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">start</span><span class="p">;</span></div><div class='line' id='LC116'>					<span class="kd">var</span> <span class="nx">endPos</span> <span class="o">=</span> <span class="nx">selection</span><span class="p">.</span><span class="nx">end</span><span class="p">;</span></div><div class='line' id='LC117'><br/></div><div class='line' id='LC118'>					<span class="k">if</span> <span class="p">(</span><span class="nx">k</span><span class="o">==</span><span class="mi">8</span><span class="p">)</span> <span class="p">{</span> <span class="c1">// backspace key</span></div><div class='line' id='LC119'>						<span class="nx">preventDefault</span><span class="p">(</span><span class="nx">e</span><span class="p">);</span></div><div class='line' id='LC120'><br/></div><div class='line' id='LC121'>						<span class="k">if</span><span class="p">(</span><span class="nx">startPos</span> <span class="o">==</span> <span class="nx">endPos</span><span class="p">){</span></div><div class='line' id='LC122'>							<span class="c1">// Remove single character</span></div><div class='line' id='LC123'>							<span class="nx">x</span><span class="p">.</span><span class="nx">value</span> <span class="o">=</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">startPos</span> <span class="o">-</span> <span class="mi">1</span><span class="p">)</span> <span class="o">+</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="nx">endPos</span><span class="p">,</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span><span class="p">);</span></div><div class='line' id='LC124'>							<span class="nx">startPos</span> <span class="o">=</span> <span class="nx">startPos</span> <span class="o">-</span> <span class="mi">1</span><span class="p">;</span></div><div class='line' id='LC125'>						<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC126'>							<span class="c1">// Remove multiple characters</span></div><div class='line' id='LC127'>							<span class="nx">x</span><span class="p">.</span><span class="nx">value</span> <span class="o">=</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">)</span> <span class="o">+</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="nx">endPos</span><span class="p">,</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span><span class="p">);</span></div><div class='line' id='LC128'>						<span class="p">}</span></div><div class='line' id='LC129'>						<span class="nx">maskAndPosition</span><span class="p">(</span><span class="nx">x</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">);</span></div><div class='line' id='LC130'>						<span class="nx">markAsDirty</span><span class="p">();</span></div><div class='line' id='LC131'>						<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC132'>					<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">k</span><span class="o">==</span><span class="mi">9</span><span class="p">)</span> <span class="p">{</span> <span class="c1">// tab key</span></div><div class='line' id='LC133'>						<span class="k">if</span><span class="p">(</span><span class="nx">dirty</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC134'>							<span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">).</span><span class="nx">change</span><span class="p">();</span></div><div class='line' id='LC135'>							<span class="nx">clearDirt</span><span class="p">();</span></div><div class='line' id='LC136'>						<span class="p">}</span></div><div class='line' id='LC137'>						<span class="k">return</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC138'>					<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span> <span class="nx">k</span><span class="o">==</span><span class="mi">46</span> <span class="o">||</span> <span class="nx">k</span><span class="o">==</span><span class="mi">63272</span> <span class="p">)</span> <span class="p">{</span> <span class="c1">// delete key (with special case for safari)</span></div><div class='line' id='LC139'>						<span class="nx">preventDefault</span><span class="p">(</span><span class="nx">e</span><span class="p">);</span></div><div class='line' id='LC140'>						<span class="k">if</span><span class="p">(</span><span class="nx">x</span><span class="p">.</span><span class="nx">selectionStart</span> <span class="o">==</span> <span class="nx">x</span><span class="p">.</span><span class="nx">selectionEnd</span><span class="p">){</span></div><div class='line' id='LC141'>							<span class="c1">// Remove single character</span></div><div class='line' id='LC142'>							<span class="nx">x</span><span class="p">.</span><span class="nx">value</span> <span class="o">=</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">)</span> <span class="o">+</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="nx">endPos</span> <span class="o">+</span> <span class="mi">1</span><span class="p">,</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span><span class="p">);</span></div><div class='line' id='LC143'>						<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC144'>							<span class="c1">//Remove multiple characters</span></div><div class='line' id='LC145'>							<span class="nx">x</span><span class="p">.</span><span class="nx">value</span> <span class="o">=</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">)</span> <span class="o">+</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">substring</span><span class="p">(</span><span class="nx">endPos</span><span class="p">,</span> <span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span><span class="p">);</span></div><div class='line' id='LC146'>						<span class="p">}</span></div><div class='line' id='LC147'>						<span class="nx">maskAndPosition</span><span class="p">(</span><span class="nx">x</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">);</span></div><div class='line' id='LC148'>						<span class="nx">markAsDirty</span><span class="p">();</span></div><div class='line' id='LC149'>						<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC150'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span> <span class="c1">// any other key</span></div><div class='line' id='LC151'>						<span class="k">return</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC152'>					<span class="p">}</span></div><div class='line' id='LC153'>				<span class="p">}</span></div><div class='line' id='LC154'><br/></div><div class='line' id='LC155'>				<span class="kd">function</span> <span class="nx">focusEvent</span><span class="p">(</span><span class="nx">e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC156'>					<span class="kd">var</span> <span class="nx">mask</span> <span class="o">=</span> <span class="nx">getDefaultMask</span><span class="p">();</span></div><div class='line' id='LC157'>					<span class="k">if</span> <span class="p">(</span><span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()</span> <span class="o">==</span> <span class="nx">mask</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC158'>						<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="s1">&#39;&#39;</span><span class="p">);</span></div><div class='line' id='LC159'>					<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()</span><span class="o">==</span><span class="s1">&#39;&#39;</span> <span class="o">&amp;&amp;</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">defaultZero</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC160'>						<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">setSymbol</span><span class="p">(</span><span class="nx">mask</span><span class="p">));</span></div><div class='line' id='LC161'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC162'>						<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">setSymbol</span><span class="p">(</span><span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()));</span></div><div class='line' id='LC163'>					<span class="p">}</span></div><div class='line' id='LC164'>					<span class="k">if</span> <span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC165'>						<span class="kd">var</span> <span class="nx">textRange</span> <span class="o">=</span> <span class="k">this</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">();</span></div><div class='line' id='LC166'>						<span class="nx">textRange</span><span class="p">.</span><span class="nx">collapse</span><span class="p">(</span><span class="kc">false</span><span class="p">);</span> <span class="c1">// set the cursor at the end of the input</span></div><div class='line' id='LC167'>						<span class="nx">textRange</span><span class="p">.</span><span class="nx">select</span><span class="p">();</span></div><div class='line' id='LC168'>					<span class="p">}</span></div><div class='line' id='LC169'>				<span class="p">}</span></div><div class='line' id='LC170'><br/></div><div class='line' id='LC171'>				<span class="kd">function</span> <span class="nx">blurEvent</span><span class="p">(</span><span class="nx">e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC172'>					<span class="k">if</span> <span class="p">(</span><span class="nx">$</span><span class="p">.</span><span class="nx">browser</span><span class="p">.</span><span class="nx">msie</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC173'>						<span class="nx">keypressEvent</span><span class="p">(</span><span class="nx">e</span><span class="p">);</span></div><div class='line' id='LC174'>					<span class="p">}</span></div><div class='line' id='LC175'><br/></div><div class='line' id='LC176'>					<span class="k">if</span> <span class="p">(</span><span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()</span> <span class="o">==</span> <span class="s1">&#39;&#39;</span> <span class="o">||</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()</span> <span class="o">==</span> <span class="nx">setSymbol</span><span class="p">(</span><span class="nx">getDefaultMask</span><span class="p">())</span> <span class="o">||</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()</span> <span class="o">==</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC177'>						<span class="k">if</span><span class="p">(</span><span class="o">!</span><span class="nx">settings</span><span class="p">.</span><span class="nx">allowZero</span><span class="p">){</span></div><div class='line' id='LC178'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="s1">&#39;&#39;</span><span class="p">);</span></div><div class='line' id='LC179'>						<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nx">settings</span><span class="p">.</span><span class="nx">symbolStay</span><span class="p">){</span></div><div class='line' id='LC180'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">getDefaultMask</span><span class="p">());</span></div><div class='line' id='LC181'>						<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC182'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">setSymbol</span><span class="p">(</span><span class="nx">getDefaultMask</span><span class="p">()));</span></div><div class='line' id='LC183'>						<span class="p">}</span></div><div class='line' id='LC184'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC185'>						<span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nx">settings</span><span class="p">.</span><span class="nx">symbolStay</span><span class="p">){</span></div><div class='line' id='LC186'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">().</span><span class="nx">replace</span><span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span><span class="p">,</span><span class="s1">&#39;&#39;</span><span class="p">));</span></div><div class='line' id='LC187'>						<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">symbolStay</span> <span class="o">&amp;&amp;</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">()</span> <span class="o">==</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span><span class="p">){</span></div><div class='line' id='LC188'>							<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">setSymbol</span><span class="p">(</span><span class="nx">getDefaultMask</span><span class="p">()));</span></div><div class='line' id='LC189'>						<span class="p">}</span></div><div class='line' id='LC190'>					<span class="p">}</span></div><div class='line' id='LC191'>				<span class="p">}</span></div><div class='line' id='LC192'><br/></div><div class='line' id='LC193'>				<span class="kd">function</span> <span class="nx">preventDefault</span><span class="p">(</span><span class="nx">e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC194'>					<span class="k">if</span> <span class="p">(</span><span class="nx">e</span><span class="p">.</span><span class="nx">preventDefault</span><span class="p">)</span> <span class="p">{</span> <span class="c1">//standard browsers</span></div><div class='line' id='LC195'>						<span class="nx">e</span><span class="p">.</span><span class="nx">preventDefault</span><span class="p">();</span></div><div class='line' id='LC196'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span> <span class="c1">// old internet explorer</span></div><div class='line' id='LC197'>						<span class="nx">e</span><span class="p">.</span><span class="nx">returnValue</span> <span class="o">=</span> <span class="kc">false</span></div><div class='line' id='LC198'>					<span class="p">}</span></div><div class='line' id='LC199'>				<span class="p">}</span></div><div class='line' id='LC200'><br/></div><div class='line' id='LC201'>				<span class="kd">function</span> <span class="nx">maskAndPosition</span><span class="p">(</span><span class="nx">x</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC202'>					<span class="kd">var</span> <span class="nx">originalLen</span> <span class="o">=</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">().</span><span class="nx">length</span><span class="p">;</span></div><div class='line' id='LC203'>					<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">maskValue</span><span class="p">(</span><span class="nx">x</span><span class="p">.</span><span class="nx">value</span><span class="p">));</span></div><div class='line' id='LC204'>					<span class="kd">var</span> <span class="nx">newLen</span> <span class="o">=</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">().</span><span class="nx">length</span><span class="p">;</span></div><div class='line' id='LC205'>					<span class="nx">startPos</span> <span class="o">=</span> <span class="nx">startPos</span> <span class="o">-</span> <span class="p">(</span><span class="nx">originalLen</span> <span class="o">-</span> <span class="nx">newLen</span><span class="p">);</span></div><div class='line' id='LC206'>					<span class="nx">setCursorPosition</span><span class="p">(</span><span class="nx">input</span><span class="p">,</span> <span class="nx">startPos</span><span class="p">);</span></div><div class='line' id='LC207'>				<span class="p">}</span></div><div class='line' id='LC208'><br/></div><div class='line' id='LC209'>				<span class="kd">function</span> <span class="nx">mask</span><span class="p">(){</span></div><div class='line' id='LC210'>					<span class="kd">var</span> <span class="nx">value</span> <span class="o">=</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">();</span></div><div class='line' id='LC211'>					<span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span><span class="nx">maskValue</span><span class="p">(</span><span class="nx">value</span><span class="p">));</span></div><div class='line' id='LC212'>				<span class="p">}</span></div><div class='line' id='LC213'><br/></div><div class='line' id='LC214'>				<span class="kd">function</span> <span class="nx">maskValue</span><span class="p">(</span><span class="nx">v</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC215'>					<span class="nx">v</span> <span class="o">=</span> <span class="nx">v</span><span class="p">.</span><span class="nx">replace</span><span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span><span class="p">,</span> <span class="s1">&#39;&#39;</span><span class="p">);</span></div><div class='line' id='LC216'><br/></div><div class='line' id='LC217'>					<span class="kd">var</span> <span class="nx">strCheck</span> <span class="o">=</span> <span class="s1">&#39;0123456789&#39;</span><span class="p">;</span></div><div class='line' id='LC218'>					<span class="kd">var</span> <span class="nx">len</span> <span class="o">=</span> <span class="nx">v</span><span class="p">.</span><span class="nx">length</span><span class="p">;</span></div><div class='line' id='LC219'>					<span class="kd">var</span> <span class="nx">a</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">,</span> <span class="nx">t</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">,</span> <span class="nx">neg</span><span class="o">=</span><span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC220'><br/></div><div class='line' id='LC221'>					<span class="k">if</span><span class="p">(</span><span class="nx">len</span> <span class="o">!=</span> <span class="mi">0</span> <span class="o">&amp;&amp;</span> <span class="nx">v</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="mi">0</span><span class="p">)</span><span class="o">==</span><span class="s1">&#39;-&#39;</span><span class="p">){</span></div><div class='line' id='LC222'>						<span class="nx">v</span> <span class="o">=</span> <span class="nx">v</span><span class="p">.</span><span class="nx">replace</span><span class="p">(</span><span class="s1">&#39;-&#39;</span><span class="p">,</span><span class="s1">&#39;&#39;</span><span class="p">);</span></div><div class='line' id='LC223'>						<span class="k">if</span><span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">allowNegative</span><span class="p">){</span></div><div class='line' id='LC224'>							<span class="nx">neg</span> <span class="o">=</span> <span class="s1">&#39;-&#39;</span><span class="p">;</span></div><div class='line' id='LC225'>						<span class="p">}</span></div><div class='line' id='LC226'>					<span class="p">}</span></div><div class='line' id='LC227'><br/></div><div class='line' id='LC228'>					<span class="k">if</span> <span class="p">(</span><span class="nx">len</span><span class="o">==</span><span class="mi">0</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC229'>						<span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nx">settings</span><span class="p">.</span><span class="nx">defaultZero</span><span class="p">)</span> <span class="k">return</span> <span class="nx">t</span><span class="p">;</span></div><div class='line' id='LC230'>						<span class="nx">t</span> <span class="o">=</span> <span class="s1">&#39;0.00&#39;</span><span class="p">;</span></div><div class='line' id='LC231'>					<span class="p">}</span></div><div class='line' id='LC232'><br/></div><div class='line' id='LC233'>					<span class="k">for</span> <span class="p">(</span><span class="kd">var</span> <span class="nx">i</span> <span class="o">=</span> <span class="mi">0</span><span class="p">;</span> <span class="nx">i</span><span class="o">&lt;</span><span class="nx">len</span><span class="p">;</span> <span class="nx">i</span><span class="o">++</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC234'>						<span class="k">if</span> <span class="p">((</span><span class="nx">v</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="nx">i</span><span class="p">)</span><span class="o">!=</span><span class="s1">&#39;0&#39;</span><span class="p">)</span> <span class="o">&amp;&amp;</span> <span class="p">(</span><span class="nx">v</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="nx">i</span><span class="p">)</span><span class="o">!=</span><span class="nx">settings</span><span class="p">.</span><span class="nx">decimal</span><span class="p">))</span> <span class="k">break</span><span class="p">;</span></div><div class='line' id='LC235'>					<span class="p">}</span></div><div class='line' id='LC236'><br/></div><div class='line' id='LC237'>					<span class="k">for</span> <span class="p">(;</span> <span class="nx">i</span> <span class="o">&lt;</span> <span class="nx">len</span><span class="p">;</span> <span class="nx">i</span><span class="o">++</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC238'>						<span class="k">if</span> <span class="p">(</span><span class="nx">strCheck</span><span class="p">.</span><span class="nx">indexOf</span><span class="p">(</span><span class="nx">v</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="nx">i</span><span class="p">))</span><span class="o">!=-</span><span class="mi">1</span><span class="p">)</span> <span class="nx">a</span><span class="o">+=</span> <span class="nx">v</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="nx">i</span><span class="p">);</span></div><div class='line' id='LC239'>					<span class="p">}</span></div><div class='line' id='LC240'>					<span class="kd">var</span> <span class="nx">n</span> <span class="o">=</span> <span class="nb">parseFloat</span><span class="p">(</span><span class="nx">a</span><span class="p">);</span></div><div class='line' id='LC241'><br/></div><div class='line' id='LC242'>					<span class="nx">n</span> <span class="o">=</span> <span class="nb">isNaN</span><span class="p">(</span><span class="nx">n</span><span class="p">)</span> <span class="o">?</span> <span class="mi">0</span> <span class="o">:</span> <span class="nx">n</span><span class="o">/</span><span class="nb">Math</span><span class="p">.</span><span class="nx">pow</span><span class="p">(</span><span class="mi">10</span><span class="p">,</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="p">);</span></div><div class='line' id='LC243'>					<span class="nx">t</span> <span class="o">=</span> <span class="nx">n</span><span class="p">.</span><span class="nx">toFixed</span><span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="p">);</span></div><div class='line' id='LC244'><br/></div><div class='line' id='LC245'>					<span class="nx">i</span> <span class="o">=</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span> <span class="o">==</span> <span class="mi">0</span> <span class="o">?</span> <span class="mi">0</span> <span class="o">:</span> <span class="mi">1</span><span class="p">;</span></div><div class='line' id='LC246'>					<span class="kd">var</span> <span class="nx">p</span><span class="p">,</span> <span class="nx">d</span> <span class="o">=</span> <span class="p">(</span><span class="nx">t</span><span class="o">=</span><span class="nx">t</span><span class="p">.</span><span class="nx">split</span><span class="p">(</span><span class="s1">&#39;.&#39;</span><span class="p">))[</span><span class="nx">i</span><span class="p">].</span><span class="nx">substr</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="p">);</span></div><div class='line' id='LC247'>					<span class="k">for</span> <span class="p">(</span><span class="nx">p</span> <span class="o">=</span> <span class="p">(</span><span class="nx">t</span><span class="o">=</span><span class="nx">t</span><span class="p">[</span><span class="mi">0</span><span class="p">]).</span><span class="nx">length</span><span class="p">;</span> <span class="p">(</span><span class="nx">p</span><span class="o">-=</span><span class="mi">3</span><span class="p">)</span><span class="o">&gt;=</span><span class="mi">1</span><span class="p">;)</span> <span class="p">{</span></div><div class='line' id='LC248'>						<span class="nx">t</span> <span class="o">=</span> <span class="nx">t</span><span class="p">.</span><span class="nx">substr</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span><span class="nx">p</span><span class="p">)</span><span class="o">+</span><span class="nx">settings</span><span class="p">.</span><span class="nx">thousands</span><span class="o">+</span><span class="nx">t</span><span class="p">.</span><span class="nx">substr</span><span class="p">(</span><span class="nx">p</span><span class="p">);</span></div><div class='line' id='LC249'>					<span class="p">}</span></div><div class='line' id='LC250'><br/></div><div class='line' id='LC251'>					<span class="k">return</span> <span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="o">&gt;</span><span class="mi">0</span><span class="p">)</span></div><div class='line' id='LC252'>					<span class="o">?</span> <span class="nx">setSymbol</span><span class="p">(</span><span class="nx">neg</span><span class="o">+</span><span class="nx">t</span><span class="o">+</span><span class="nx">settings</span><span class="p">.</span><span class="nx">decimal</span><span class="o">+</span><span class="nx">d</span><span class="o">+</span><span class="nb">Array</span><span class="p">((</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="o">+</span><span class="mi">1</span><span class="p">)</span><span class="o">-</span><span class="nx">d</span><span class="p">.</span><span class="nx">length</span><span class="p">).</span><span class="nx">join</span><span class="p">(</span><span class="mi">0</span><span class="p">))</span></div><div class='line' id='LC253'>					<span class="o">:</span> <span class="nx">setSymbol</span><span class="p">(</span><span class="nx">neg</span><span class="o">+</span><span class="nx">t</span><span class="p">);</span></div><div class='line' id='LC254'>				<span class="p">}</span></div><div class='line' id='LC255'><br/></div><div class='line' id='LC256'>				<span class="kd">function</span> <span class="nx">getDefaultMask</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC257'>					<span class="kd">var</span> <span class="nx">n</span> <span class="o">=</span> <span class="nb">parseFloat</span><span class="p">(</span><span class="s1">&#39;0&#39;</span><span class="p">)</span><span class="o">/</span><span class="nb">Math</span><span class="p">.</span><span class="nx">pow</span><span class="p">(</span><span class="mi">10</span><span class="p">,</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="p">);</span></div><div class='line' id='LC258'>					<span class="k">return</span> <span class="p">(</span><span class="nx">n</span><span class="p">.</span><span class="nx">toFixed</span><span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">precision</span><span class="p">)).</span><span class="nx">replace</span><span class="p">(</span><span class="k">new</span> <span class="nb">RegExp</span><span class="p">(</span><span class="s1">&#39;\\.&#39;</span><span class="p">,</span><span class="s1">&#39;g&#39;</span><span class="p">),</span><span class="nx">settings</span><span class="p">.</span><span class="nx">decimal</span><span class="p">);</span></div><div class='line' id='LC259'>				<span class="p">}</span></div><div class='line' id='LC260'><br/></div><div class='line' id='LC261'>				<span class="kd">function</span> <span class="nx">setSymbol</span><span class="p">(</span><span class="nx">value</span><span class="p">){</span></div><div class='line' id='LC262'>					<span class="k">if</span> <span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span> <span class="o">!=</span> <span class="s1">&#39;&#39;</span><span class="p">){</span></div><div class='line' id='LC263'>						<span class="kd">var</span> <span class="nx">operator</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC264'>						<span class="k">if</span><span class="p">(</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span> <span class="o">!=</span> <span class="mi">0</span> <span class="o">&amp;&amp;</span> <span class="nx">value</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="mi">0</span><span class="p">)</span> <span class="o">==</span> <span class="s1">&#39;-&#39;</span><span class="p">){</span></div><div class='line' id='LC265'>							<span class="nx">value</span> <span class="o">=</span> <span class="nx">value</span><span class="p">.</span><span class="nx">replace</span><span class="p">(</span><span class="s1">&#39;-&#39;</span><span class="p">,</span> <span class="s1">&#39;&#39;</span><span class="p">);</span></div><div class='line' id='LC266'>							<span class="nx">operator</span> <span class="o">=</span> <span class="s1">&#39;-&#39;</span><span class="p">;</span></div><div class='line' id='LC267'>						<span class="p">}</span></div><div class='line' id='LC268'><br/></div><div class='line' id='LC269'>						<span class="k">if</span><span class="p">(</span><span class="nx">value</span><span class="p">.</span><span class="nx">substr</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span><span class="p">.</span><span class="nx">length</span><span class="p">)</span> <span class="o">!=</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span><span class="p">){</span></div><div class='line' id='LC270'>							<span class="nx">value</span> <span class="o">=</span> <span class="nx">operator</span> <span class="o">+</span> <span class="nx">settings</span><span class="p">.</span><span class="nx">symbol</span> <span class="o">+</span> <span class="nx">value</span><span class="p">;</span></div><div class='line' id='LC271'>						<span class="p">}</span></div><div class='line' id='LC272'>					<span class="p">}</span></div><div class='line' id='LC273'>					<span class="k">return</span> <span class="nx">value</span><span class="p">;</span></div><div class='line' id='LC274'>				<span class="p">}</span></div><div class='line' id='LC275'><br/></div><div class='line' id='LC276'>				<span class="kd">function</span> <span class="nx">changeSign</span><span class="p">(</span><span class="nx">input</span><span class="p">){</span></div><div class='line' id='LC277'>					<span class="kd">var</span> <span class="nx">inputValue</span> <span class="o">=</span> <span class="nx">input</span><span class="p">.</span><span class="nx">val</span><span class="p">();</span></div><div class='line' id='LC278'>					<span class="k">if</span> <span class="p">(</span><span class="nx">settings</span><span class="p">.</span><span class="nx">allowNegative</span><span class="p">){</span></div><div class='line' id='LC279'>						<span class="k">if</span> <span class="p">(</span><span class="nx">inputValue</span> <span class="o">!=</span> <span class="s1">&#39;&#39;</span> <span class="o">&amp;&amp;</span> <span class="nx">inputValue</span><span class="p">.</span><span class="nx">charAt</span><span class="p">(</span><span class="mi">0</span><span class="p">)</span> <span class="o">==</span> <span class="s1">&#39;-&#39;</span><span class="p">){</span></div><div class='line' id='LC280'>							<span class="k">return</span> <span class="nx">inputValue</span><span class="p">.</span><span class="nx">replace</span><span class="p">(</span><span class="s1">&#39;-&#39;</span><span class="p">,</span><span class="s1">&#39;&#39;</span><span class="p">);</span></div><div class='line' id='LC281'>						<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC282'>							<span class="k">return</span> <span class="s1">&#39;-&#39;</span> <span class="o">+</span> <span class="nx">inputValue</span><span class="p">;</span></div><div class='line' id='LC283'>						<span class="p">}</span></div><div class='line' id='LC284'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC285'>						<span class="k">return</span> <span class="nx">inputValue</span><span class="p">;</span></div><div class='line' id='LC286'>					<span class="p">}</span></div><div class='line' id='LC287'>				<span class="p">}</span></div><div class='line' id='LC288'><br/></div><div class='line' id='LC289'>				<span class="kd">function</span> <span class="nx">setCursorPosition</span><span class="p">(</span><span class="nx">input</span><span class="p">,</span> <span class="nx">pos</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC290'>					<span class="c1">// I&#39;m not sure if we need to jqueryfy input</span></div><div class='line' id='LC291'>					<span class="nx">$</span><span class="p">(</span><span class="nx">input</span><span class="p">).</span><span class="nx">each</span><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">index</span><span class="p">,</span> <span class="nx">elem</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC292'>						<span class="k">if</span> <span class="p">(</span><span class="nx">elem</span><span class="p">.</span><span class="nx">setSelectionRange</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC293'>							<span class="nx">elem</span><span class="p">.</span><span class="nx">focus</span><span class="p">();</span></div><div class='line' id='LC294'>							<span class="nx">elem</span><span class="p">.</span><span class="nx">setSelectionRange</span><span class="p">(</span><span class="nx">pos</span><span class="p">,</span> <span class="nx">pos</span><span class="p">);</span></div><div class='line' id='LC295'>						<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">elem</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC296'>							<span class="kd">var</span> <span class="nx">range</span> <span class="o">=</span> <span class="nx">elem</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">();</span></div><div class='line' id='LC297'>							<span class="nx">range</span><span class="p">.</span><span class="nx">collapse</span><span class="p">(</span><span class="kc">true</span><span class="p">);</span></div><div class='line' id='LC298'>							<span class="nx">range</span><span class="p">.</span><span class="nx">moveEnd</span><span class="p">(</span><span class="s1">&#39;character&#39;</span><span class="p">,</span> <span class="nx">pos</span><span class="p">);</span></div><div class='line' id='LC299'>							<span class="nx">range</span><span class="p">.</span><span class="nx">moveStart</span><span class="p">(</span><span class="s1">&#39;character&#39;</span><span class="p">,</span> <span class="nx">pos</span><span class="p">);</span></div><div class='line' id='LC300'>							<span class="nx">range</span><span class="p">.</span><span class="nx">select</span><span class="p">();</span></div><div class='line' id='LC301'>						<span class="p">}</span></div><div class='line' id='LC302'>					<span class="p">});</span></div><div class='line' id='LC303'>					<span class="k">return</span> <span class="k">this</span><span class="p">;</span></div><div class='line' id='LC304'>				<span class="p">};</span></div><div class='line' id='LC305'><br/></div><div class='line' id='LC306'>				<span class="kd">function</span> <span class="nx">getInputSelection</span><span class="p">(</span><span class="nx">el</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC307'>					<span class="kd">var</span> <span class="nx">start</span> <span class="o">=</span> <span class="mi">0</span><span class="p">,</span> <span class="nx">end</span> <span class="o">=</span> <span class="mi">0</span><span class="p">,</span> <span class="nx">normalizedValue</span><span class="p">,</span> <span class="nx">range</span><span class="p">,</span> <span class="nx">textInputRange</span><span class="p">,</span> <span class="nx">len</span><span class="p">,</span> <span class="nx">endRange</span><span class="p">;</span></div><div class='line' id='LC308'><br/></div><div class='line' id='LC309'>					<span class="k">if</span> <span class="p">(</span><span class="k">typeof</span> <span class="nx">el</span><span class="p">.</span><span class="nx">selectionStart</span> <span class="o">==</span> <span class="s2">&quot;number&quot;</span> <span class="o">&amp;&amp;</span> <span class="k">typeof</span> <span class="nx">el</span><span class="p">.</span><span class="nx">selectionEnd</span> <span class="o">==</span> <span class="s2">&quot;number&quot;</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC310'>						<span class="nx">start</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">selectionStart</span><span class="p">;</span></div><div class='line' id='LC311'>						<span class="nx">end</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">selectionEnd</span><span class="p">;</span></div><div class='line' id='LC312'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC313'>						<span class="nx">range</span> <span class="o">=</span> <span class="nb">document</span><span class="p">.</span><span class="nx">selection</span><span class="p">.</span><span class="nx">createRange</span><span class="p">();</span></div><div class='line' id='LC314'><br/></div><div class='line' id='LC315'>						<span class="k">if</span> <span class="p">(</span><span class="nx">range</span> <span class="o">&amp;&amp;</span> <span class="nx">range</span><span class="p">.</span><span class="nx">parentElement</span><span class="p">()</span> <span class="o">==</span> <span class="nx">el</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC316'>							<span class="nx">len</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">length</span><span class="p">;</span></div><div class='line' id='LC317'>							<span class="nx">normalizedValue</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">value</span><span class="p">.</span><span class="nx">replace</span><span class="p">(</span><span class="sr">/\r\n/g</span><span class="p">,</span> <span class="s2">&quot;\n&quot;</span><span class="p">);</span></div><div class='line' id='LC318'><br/></div><div class='line' id='LC319'>							<span class="c1">// Create a working TextRange that lives only in the input</span></div><div class='line' id='LC320'>							<span class="nx">textInputRange</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">();</span></div><div class='line' id='LC321'>							<span class="nx">textInputRange</span><span class="p">.</span><span class="nx">moveToBookmark</span><span class="p">(</span><span class="nx">range</span><span class="p">.</span><span class="nx">getBookmark</span><span class="p">());</span></div><div class='line' id='LC322'><br/></div><div class='line' id='LC323'>							<span class="c1">// Check if the start and end of the selection are at the very end</span></div><div class='line' id='LC324'>							<span class="c1">// of the input, since moveStart/moveEnd doesn&#39;t return what we want</span></div><div class='line' id='LC325'>							<span class="c1">// in those cases</span></div><div class='line' id='LC326'>							<span class="nx">endRange</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">();</span></div><div class='line' id='LC327'>							<span class="nx">endRange</span><span class="p">.</span><span class="nx">collapse</span><span class="p">(</span><span class="kc">false</span><span class="p">);</span></div><div class='line' id='LC328'><br/></div><div class='line' id='LC329'>							<span class="k">if</span> <span class="p">(</span><span class="nx">textInputRange</span><span class="p">.</span><span class="nx">compareEndPoints</span><span class="p">(</span><span class="s2">&quot;StartToEnd&quot;</span><span class="p">,</span> <span class="nx">endRange</span><span class="p">)</span> <span class="o">&gt;</span> <span class="o">-</span><span class="mi">1</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC330'>								<span class="nx">start</span> <span class="o">=</span> <span class="nx">end</span> <span class="o">=</span> <span class="nx">len</span><span class="p">;</span></div><div class='line' id='LC331'>							<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC332'>								<span class="nx">start</span> <span class="o">=</span> <span class="o">-</span><span class="nx">textInputRange</span><span class="p">.</span><span class="nx">moveStart</span><span class="p">(</span><span class="s2">&quot;character&quot;</span><span class="p">,</span> <span class="o">-</span><span class="nx">len</span><span class="p">);</span></div><div class='line' id='LC333'>								<span class="nx">start</span> <span class="o">+=</span> <span class="nx">normalizedValue</span><span class="p">.</span><span class="nx">slice</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">start</span><span class="p">).</span><span class="nx">split</span><span class="p">(</span><span class="s2">&quot;\n&quot;</span><span class="p">).</span><span class="nx">length</span> <span class="o">-</span> <span class="mi">1</span><span class="p">;</span></div><div class='line' id='LC334'><br/></div><div class='line' id='LC335'>								<span class="k">if</span> <span class="p">(</span><span class="nx">textInputRange</span><span class="p">.</span><span class="nx">compareEndPoints</span><span class="p">(</span><span class="s2">&quot;EndToEnd&quot;</span><span class="p">,</span> <span class="nx">endRange</span><span class="p">)</span> <span class="o">&gt;</span> <span class="o">-</span><span class="mi">1</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC336'>									<span class="nx">end</span> <span class="o">=</span> <span class="nx">len</span><span class="p">;</span></div><div class='line' id='LC337'>								<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC338'>									<span class="nx">end</span> <span class="o">=</span> <span class="o">-</span><span class="nx">textInputRange</span><span class="p">.</span><span class="nx">moveEnd</span><span class="p">(</span><span class="s2">&quot;character&quot;</span><span class="p">,</span> <span class="o">-</span><span class="nx">len</span><span class="p">);</span></div><div class='line' id='LC339'>									<span class="nx">end</span> <span class="o">+=</span> <span class="nx">normalizedValue</span><span class="p">.</span><span class="nx">slice</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="nx">end</span><span class="p">).</span><span class="nx">split</span><span class="p">(</span><span class="s2">&quot;\n&quot;</span><span class="p">).</span><span class="nx">length</span> <span class="o">-</span> <span class="mi">1</span><span class="p">;</span></div><div class='line' id='LC340'>								<span class="p">}</span></div><div class='line' id='LC341'>							<span class="p">}</span></div><div class='line' id='LC342'>						<span class="p">}</span></div><div class='line' id='LC343'>					<span class="p">}</span></div><div class='line' id='LC344'><br/></div><div class='line' id='LC345'>					<span class="k">return</span> <span class="p">{</span></div><div class='line' id='LC346'>						<span class="nx">start</span><span class="o">:</span> <span class="nx">start</span><span class="p">,</span></div><div class='line' id='LC347'>						<span class="nx">end</span><span class="o">:</span> <span class="nx">end</span></div><div class='line' id='LC348'>					<span class="p">};</span></div><div class='line' id='LC349'>				<span class="p">}</span> <span class="c1">// getInputSelection</span></div><div class='line' id='LC350'><br/></div><div class='line' id='LC351'>				<span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nx">input</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span><span class="s2">&quot;readonly&quot;</span><span class="p">)){</span></div><div class='line' id='LC352'>					<span class="nx">input</span><span class="p">.</span><span class="nx">unbind</span><span class="p">(</span><span class="s1">&#39;.maskMoney&#39;</span><span class="p">);</span></div><div class='line' id='LC353'>					<span class="nx">input</span><span class="p">.</span><span class="nx">bind</span><span class="p">(</span><span class="s1">&#39;keypress.maskMoney&#39;</span><span class="p">,</span> <span class="nx">keypressEvent</span><span class="p">);</span></div><div class='line' id='LC354'>					<span class="nx">input</span><span class="p">.</span><span class="nx">bind</span><span class="p">(</span><span class="s1">&#39;keydown.maskMoney&#39;</span><span class="p">,</span> <span class="nx">keydownEvent</span><span class="p">);</span></div><div class='line' id='LC355'>					<span class="nx">input</span><span class="p">.</span><span class="nx">bind</span><span class="p">(</span><span class="s1">&#39;blur.maskMoney&#39;</span><span class="p">,</span> <span class="nx">blurEvent</span><span class="p">);</span></div><div class='line' id='LC356'>					<span class="nx">input</span><span class="p">.</span><span class="nx">bind</span><span class="p">(</span><span class="s1">&#39;focus.maskMoney&#39;</span><span class="p">,</span> <span class="nx">focusEvent</span><span class="p">);</span></div><div class='line' id='LC357'>					<span class="nx">input</span><span class="p">.</span><span class="nx">bind</span><span class="p">(</span><span class="s1">&#39;mask.maskMoney&#39;</span><span class="p">,</span> <span class="nx">mask</span><span class="p">);</span></div><div class='line' id='LC358'>				<span class="p">}</span></div><div class='line' id='LC359'>			<span class="p">})</span></div><div class='line' id='LC360'>		<span class="p">}</span></div><div class='line' id='LC361'>	<span class="p">}</span></div><div class='line' id='LC362'><br/></div><div class='line' id='LC363'>	<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">maskMoney</span> <span class="o">=</span> <span class="kd">function</span><span class="p">(</span><span class="nx">method</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC364'>		<span class="k">if</span> <span class="p">(</span> <span class="nx">methods</span><span class="p">[</span><span class="nx">method</span><span class="p">]</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC365'>			<span class="k">return</span> <span class="nx">methods</span><span class="p">[</span><span class="nx">method</span><span class="p">].</span><span class="nx">apply</span><span class="p">(</span> <span class="k">this</span><span class="p">,</span> <span class="nb">Array</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">slice</span><span class="p">.</span><span class="nx">call</span><span class="p">(</span> <span class="nx">arguments</span><span class="p">,</span> <span class="mi">1</span> <span class="p">));</span></div><div class='line' id='LC366'>		<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">method</span> <span class="o">===</span> <span class="s1">&#39;object&#39;</span> <span class="o">||</span> <span class="o">!</span> <span class="nx">method</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC367'>			<span class="k">return</span> <span class="nx">methods</span><span class="p">.</span><span class="nx">init</span><span class="p">.</span><span class="nx">apply</span><span class="p">(</span> <span class="k">this</span><span class="p">,</span> <span class="nx">arguments</span> <span class="p">);</span></div><div class='line' id='LC368'>		<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC369'>			<span class="nx">$</span><span class="p">.</span><span class="nx">error</span><span class="p">(</span> <span class="s1">&#39;Method &#39;</span> <span class="o">+</span>  <span class="nx">method</span> <span class="o">+</span> <span class="s1">&#39; does not exist on jQuery.maskMoney&#39;</span> <span class="p">);</span></div><div class='line' id='LC370'>		<span class="p">}</span></div><div class='line' id='LC371'>	<span class="p">};</span></div><div class='line' id='LC372'><span class="p">})(</span><span class="nb">window</span><span class="p">.</span><span class="nx">jQuery</span> <span class="o">||</span> <span class="nb">window</span><span class="p">.</span><span class="nx">Zepto</span><span class="p">);</span></div></pre></div>
          </td>
        </tr>
      </table>
  </div>

  </div>
</div>

<a href="#jump-to-line" rel="facebox[.linejump]" data-hotkey="l" class="js-jump-to-line" style="display:none">Jump to Line</a>
<div id="jump-to-line" style="display:none">
  <form accept-charset="UTF-8" class="js-jump-to-line-form">
    <input class="linejump-input js-jump-to-line-field" type="text" placeholder="Jump to line&hellip;" autofocus>
    <button type="submit" class="button">Go</button>
  </form>
</div>

        </div>

      </div><!-- /.repo-container -->
      <div class="modal-backdrop"></div>
    </div><!-- /.container -->
  </div><!-- /.site -->


    </div><!-- /.wrapper -->

      <div class="container">
  <div class="site-footer">
    <ul class="site-footer-links right">
      <li><a href="https://status.github.com/">Status</a></li>
      <li><a href="http://developer.github.com">API</a></li>
      <li><a href="http://training.github.com">Training</a></li>
      <li><a href="http://shop.github.com">Shop</a></li>
      <li><a href="/blog">Blog</a></li>
      <li><a href="/about">About</a></li>

    </ul>

    <a href="/">
      <span class="mega-octicon octicon-mark-github"></span>
    </a>

    <ul class="site-footer-links">
      <li>&copy; 2013 <span title="0.04594s from fe17.rs.github.com">GitHub</span>, Inc.</li>
        <li><a href="/site/terms">Terms</a></li>
        <li><a href="/site/privacy">Privacy</a></li>
        <li><a href="/security">Security</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
  </div><!-- /.site-footer -->
</div><!-- /.container -->


    <div class="fullscreen-overlay js-fullscreen-overlay" id="fullscreen_overlay">
  <div class="fullscreen-container js-fullscreen-container">
    <div class="textarea-wrap">
      <textarea name="fullscreen-contents" id="fullscreen-contents" class="js-fullscreen-contents" placeholder="" data-suggester="fullscreen_suggester"></textarea>
          <div class="suggester-container">
              <div class="suggester fullscreen-suggester js-navigation-container" id="fullscreen_suggester"
                 data-url="/plentz/jquery-maskmoney/suggestions/commit">
              </div>
          </div>
    </div>
  </div>
  <div class="fullscreen-sidebar">
    <a href="#" class="exit-fullscreen js-exit-fullscreen tooltipped leftwards" title="Exit Zen Mode">
      <span class="mega-octicon octicon-screen-normal"></span>
    </a>
    <a href="#" class="theme-switcher js-theme-switcher tooltipped leftwards"
      title="Switch themes">
      <span class="octicon octicon-color-mode"></span>
    </a>
  </div>
</div>



    <div id="ajax-error-message" class="flash flash-error">
      <span class="octicon octicon-alert"></span>
      <a href="#" class="octicon octicon-remove-close close ajax-error-dismiss"></a>
      Something went wrong with that request. Please try again.
    </div>

    
  </body>
</html>


# LTI Consumer Library for CodeIgniter 3.x

This library can be used to create LTI Consumer connections from a Master platform built with CodeIgniter. Users will log into your website and this library can then automatically log the user into third party platforms by authenticating via OAuth.

Currently this is used for SSO integrations only but more features can be added on request. Send a request through the [Issue Tracker](https://bitbucket.org/JackWillDavis/codeigniter-ltic/issues) if you want anything adding.

Full guidelines for the Learning Tools Interoperability standards can be found [here](https://www.imsglobal.org/activity/learning-tools-interoperability).

**Written By: [Jack W. Davis](http://www.jackwdavis.com) ([@JackWillDavis](https://github.com/JackWillDavis))**

**Sponsored By: [Buttercups Training Ltd](http://buttercupstraining.co.uk)**

## Usage Guide

#### Step 1: Load the library

Load the library, passing the initial values for the launch URL, API key and API secret to the constructor as below:

 ```
$this->load->library('ltic', array(
  "launch_url" => "https://example.com/LTI/Login",
  "key" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
  "secret" => "12345678901234567890"
));
 ```

All three parameters are required although they can be changed later on if needed using the methods towards the bottom of this README.

#### Step 2: Assign your launch data

At minimum, this will be a `user_id`, you can add as many values as you need to here. Call `setLaunchData()` to assign new keys, see below for an example:

```
$params = array(
  "user_id" => "USER-1234567890",
  "resource_link_id" => "RESOURCE-1234567890",
  "roles" => "Learner",
  "lis_person_name_full" => "Foo Bar",
  "lis_person_name_family" => "Bar",
  "lis_person_name_given" => "Foo"
);
$this->ltic->setLaunchData($params);
```

See  [here](https://www.imsglobal.org/specs/ltiv1p0/implementation-guide) for the list of all possible keys and check with your LTI Provider to see which ones are required for their particular system.

#### Step 3: Get the OAuth Signature

Instruct the LTIC library to create the OAuth request and receive the signature, or `false` if data hasn't been set correctly.

```
$signature = $this->ltic->createRequest();
```

#### Step 4: Build the form to POST the user

The LTI specifications require the data to be POSTed to the Provider system. See below for an example:

```
$signature = $this->ltic->createRequest();

if($signature)
{
  $data['lti_form'] = array(
    "launch_url" => $this->ltic->getLaunchUrl(),
    "launch_data" => $this->ltic->getLaunchData(),
    "signature" => $signature
  );
}

$this->load->view('login', $data);

```

## Full code example

```
//Load the LTI Consumer library
$this->load->library('ltic', array(
  "launch_url" => "https://example.com/LTI/Login",
  "key" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
  "secret" => "12345678901234567890"
));

//Add data for the user you are logging in
$params = array(
  "user_id" => "USER-1234567890",
  "resource_link_id" => "RESOURCE-1234567890",
  "roles" => "Learner",
  "lis_person_name_full" => "Foo Bar",
  "lis_person_name_family" => "Bar",
  "lis_person_name_given" => "Foo"
);
$this->ltic->setLaunchData($params);

//Create the OAuth Signature
$signature = $this->ltic->createRequest();

//If you have received an signature, collect data
if($signature)
{
  $data['lti_form'] = array(
    "launch_url" => $this->ltic->getLaunchUrl(),
    "launch_data" => $this->ltic->getLaunchData(),
    "signature" => $signature
  );
}

//Load the CodeIgniter template and pass data through
$this->load->view('login', $data);

```
On the front end, you would then do something like:

```
<?php if(isset($lti_form)){ ?>
  <form id="ltiLaunchForm" name="ltiLaunchForm" method="POST" action="<?php echo $lti_form['launch_url']; ?>">
    <?php foreach ($lti_form['launch_data'] as $k => $v ) { ?>
    	<input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>">
    <?php } ?>
    <input type="hidden" name="oauth_signature" value="<?php echo $lti_form['signature']; ?>">
  <button type="submit">Launch</button>
  </form>
<?php } ?>

```

## Available Methods

```
$this->ltic->setLaunchUrl(String $launch_url);

//Set the URL which launch data should be POSTed to.
//Is also set via __construct() so rarely used.
```

```
$this->ltic->getLaunchUrl();

//Retrieve the currently set launch URL.
//Is also set via __construct() so rarely used.
```

```
$this->ltic->setKey(String $key);

//Set the API Key.
//Is also set via __construct() so rarely used.
```

```
$this->ltic->getKey();

//Retrieve the currently set API Key.
//Is also set via __construct() so rarely used.
```

```
$this->ltic->setSecret(String $secret);

//Set the API Secret.
//Is also set via __construct() so rarely used.
```

```
$this->ltic->getSecret();

//Retrieve the currently set API Secret.
//Is also set via __construct() so rarely used.
```

```
$this->ltic->setLaunchData(Array $launch_data);

//Set new keys to be added to the launch data array.
```

```
$this->ltic->getLaunchData();

//Retrieve the currently set launch data as an array.
```

```
$this->ltic->createSignature();

//Use this when ready to generate the OAuth signature.
//This returns false if any __construct parameters are missing.
```

```
$this->ltic->debug()

//This will print any currently set data to the screen.
//Use to check that you are passing through info correctly.
//This exits the code so don't use on production sites!
```

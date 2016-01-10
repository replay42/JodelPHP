# JodelPHP

JodelPHP is a PHP Interface for Jodel (http://jodel-app.com) based on the idea of JodelPy

### Features

  - Setting your Position
  - Get Posts
  - Get Loudest Posts
  - Get Newest Posts
  - Get most discussed Posts
  - Get your own Posts
  - Get your loudest Posts
  - Get your answers
  - Get your current Karma
  - Post to Jodel
  - Comment to other Posts
  - Post Image to Jodel
  - Up- & Downvote
  - Delete your Post
  - Getting an Access Token

### Usage
#### Setup
```php
include('jodel.class.php');

// array( $lat, $lng, $city, $country )
$position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE');

// Create new Instance
// Set Udid to '', random Udid is generated each time. Optionally set a fixed sha256 here.
// Set Position
// Udid can be empty, position has to be set!
$jodel = new Jodel( $udid = '', $position);
```

#### Sample Calls for usage
```php
// Get Posts
$jodel->getPosts();

// Get loudest posts within 10km
$jodel->getLoudestPosts();

// Get most discussed posts within 10km
$jodel->getMostDiscussed();

// Get newest posts
$jodel->getNewestPosts();

// Get your Posts
$jodel->getMyPosts();

// Get your Karma
$jodel->getKarma();

// Get your loudest posts
$jodel->getMyLoudestPosts();

// Get your answers
$jodel->getMyAnswers();

// Post to Jodel
$jodel->post( $text );

// Post Image to jodel
$jodel->postImage( $path );

// Post Comment under another Jodel
$jodel->postComment( $ancestor, $text );

// Delete your Posts
$jodel->deletePost( $postId );

// Upvote any post
$jodel->upVote( $postId );

// Downvote any post
$jodel->downVote( $postId );
```

### Thanks to
- Thanks to rmccue for his "Requests" PHP Library https://github.com/rmccue/Requests/
- Thanks a lot to jafrewa for his Python-Code. Visit him https://github.com/jafrewa/JodelPy/

### Note
  - You can only downvote posts if you've earned some karma already
  - The value of $city is shown to other jodel-users as entered here. So if you make a mistake, others will see that 
  - The API only returns the 25 most recent posts and their comments. (I think 25...)

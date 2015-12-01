# JodelPHP

JodelPHP is a PHP Interface for Jodel (http://jodel-app.com) based on the idea of JodelPy // github.com/jafrewa/JodelPy/

### Features

  - Setting your Position
  - Get Posts
  - Get your own Posts
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

// Create new Instance
// Set Udid to '', random Udid is generated each time
// Optionally set a fixed sha256 here.
$jodel = new Jodel( $udid = '' );

// Set Position.
// setPos( $lat, $lng, $city, $country = 'DE')
$jodel->setPos(50.1183, 8.7011, 'Frankfurt am Main', 'DE');
```

#### Sample Calls for usage
```php
// Get Posts
$jodel->getPosts();

// Get your Posts
$jodel->getMyPosts();

// Get your Karma
$jodel->getKarma();

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
- Thanks to rmccue for his "Requests" PHP Library ( https://github.com/rmccue/Requests/ )
- Thanks a lot to jafrewa for his Python-Code. Visit him https://github.com/jafrewa/JodelPy/





# Client Library for encoding Videos with HeyWatch #

HeyWatch is a Video Encoding Web Service.

For more information:

* HeyWatch: http://www.heywatchencoding.com
* API Documentation: http://www.heywatchencoding.com/documentation
* Contact: [heywatch at particle-s.com](mailto:heywatch at particle-s.com)
* Twitter: [@heywatch](http://twitter.com/heywatch) / [@sadikzzz](http://twitter.com/sadikzzz)

## Install ##

To install the HeyWatch PHP library, you need [composer](http://getcomposer.org) first:

``` console
curl -sS https://getcomposer.org/installer | php
```

Edit `composer.json`:

```json
{
    "require": {
        "heywatch/heywatch": "1.*"
    }
}
```

Install the depencies by executing `composer`:

```console
php composer.phar install
```

## Usage ##

```php
// auto load the dependencies
require_once "vendor/autoload.php";

// login with your HeyWatch username and password
$hw = new HeyWatch($username, $passwd);

// get all your videos
$hw->all("video");

➔ (
  [0] => Array
      (
          [created_at] => 2013-06-12T18:19:41+02:00
          [updated_at] => 2013-06-12T18:19:41+02:00
          [id] => 25212570
          [title] => myvideofilename
          [filename] => 12893703
          [link] => http://heywatch.com/video/25212570.bin
          [specs] => Array
              (
                  [thumb] => http://94.23.62.218/12/18/ffb930957331eb2300b36ed60adcfa6c/12893703.jpg
                  [mime_type] => video/mp4
                  [size] => 318
                  [video] => Array
                      (
                          [stream] => 0
                          [codec] => mpeg4
                          [bitrate] => 501
                          [height] => 240
                          [container] => mov
                          [aspect] => 1.33
                          [length] => 5
                          [pix_format] => yuv420p
                          [fps] => 15
                          [rotation] => 0
                          [width] => 320
                      )

                  [audio] => Array
                      (
                          [stream] => 0.1
                          [codec] => aac
                          [bitrate] => 53
                          [sample_rate] => 24000
                          [channels] => 2
                          [synched] => 1
                      )

              )

          [url] => http://94.23.62.218/12/18/ffb72a5ad3601bdbe6d50b5fcdbdfff0/12893703
      )
  )

// get information about a specific video
$hw->info("video", 9662090);
```

### Create a download ###

```php
$hw->create("download", array("url" => "http://site.com/yourvideo.mp4", "title" => "yourtitle"));

➔ (
  [id] => 12904198
  [created_at] => 2013-06-13T12:58:35+02:00
  [updated_at] => 2013-06-13T12:58:35+02:00
  [status] => pending
  [video_id] => 0
  [title] => yourtitle
  [error_msg] =>
  [length] => 0
  [error_code] =>
  [progress] => Array
      (
          [current_length] => 0
          [speed] => 0
          [time_left] => ??
          [percent] => 0
      )

  [url] => http://site.com/yourvideo.mp4
)
```

### Create a job ###

```php
$hw->create("job", array("video_id" => 9662090, "format_id" => "ios_720p", "ping_url" => "http://yoursite.com/ping/heywatch?postid=123434", "s3_directive" => "s3://accesskey:secretkey@myvideobucket/ios/123434.mp4"));

➔ Array
(
  [encoded_video_id] => 0
  [created_at] => 2013-06-13T13:00:00+02:00
  [http_upload_directive] =>
  [ftp_directive] =>
  [format_id] => ios_720p
  [updated_at] => 2013-06-13T13:00:00+02:00
  [id] => 12991370
  [cf_directive] =>
  [video_id] => 9662090
  [status] => pending
  [error_code] =>
  [progress] => 0
  [ping_url] => http://yoursite.com/ping/heywatch?postid=123434
  [encoding_options] => Array
      (
      )

  [error_msg] =>
  [s3_directive] => s3://accesskey:secretkey@myvideobucket/ios/123434.mp4
)
```

### Delete a video ###

```php
$hw->delete("video", 9662090);

➔ True
```

### Generating thumbnails ###

```php
// Async method, you'll receive the thumbnails to
// your s3 account and get pinged when it's done
$hw->create("preview/thumbnails", array("media_id" => 9662142, "number" => 6, "s3_directive" => "s3://accesskey:secretkey@mybucket/thumbnails/", "ping_url" => "http://site.com/ping/heywatch/thumbs"));

➔ True
```

### Errors ###

```php
$hw->create("download", array("url" => "not_a_valid_url"));

Fatal error: Uncaught exception 'Guzzle\Http\Exception\ClientErrorResponseException' with message 'Client error response
```

Released under the [MIT license](http://www.opensource.org/licenses/mit-license.php).

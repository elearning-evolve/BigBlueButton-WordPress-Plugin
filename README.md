# Video Conferencing with BigBlueButton (BBB) #


Contributors: blindsidenetworks, jfederico, yfngdu, elearningevolve, adeelraza_786@hotmail.com  
Donate link: https://elearningevolve.com/products/donate/  
Tags: BigBlueButton, BigBlueButtom, BBB, bbb, bigbluebutton, videoconferencing, virtual classroom, web conferencing, online teaching, learning management system, LMS, online session, live training
Requires at least: 5.1  
Tested up to: 5.9.3  
Requires PHP: 7.2  
Stable tag: 1.4.2  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

A [BigBlueButton (BBB) WordPress plugin](https://wordpress.org/plugins/video-conferencing-with-bbb) that enables you to create virtual classrooms on your WP site. BigBlueButton is an open-source video conferencing tool that is "Built For Teachers".

## Description ##

[Video Conferencing with BBB](https://wordpress.org/plugins/video-conferencing-with-bbb) integrates [BigBlueButton](https://bigbluebutton.org/) into WordPress through which teachers can manage their virtual classrooms right from the WP dashboard.

This plugin is a fork of the [BigBlueButton plugin](https://wordpress.org/plugins/bigbluebutton/) initially released by Blindside Networks but no longer maintained.

BBB is an open-source video conferencing tool that is designed and **"Built For Teachers"**. It has all the core features you would expect in a web conferencing system. Additionally, it offers features that can empower teachers to engage their students in the virtual classroom by enabling active collaboration.

[See All BBB Features](https://support.blindsidenetworks.com/hc/en-us/articles/360052738972-What-are-the-features-in-BigBlueButton-)

### BBB WordPress Plugin Features ###
The BBB WordPress plugin enables the user to create BBB rooms right from the WordPress dashboard. Once the room is created it can be added to any WordPress page through a simple shortcode. There is also a possibility to enter multiple rooms in the shortcode to let the user choose the room that they want to join.

The student can simply click Join from the page where the shortcode is added and enter the BBB room where the teacher can initiate a virtual classroom session.

After the session is over the plugin can also display the recording of the session on the same page so that the students can take the keynotes from the session later on.

### Pro Version Features ###
There is also a Pro version available with this plugin that offers the below features:
* Embed BigBlueButton Room on WordPress
* Set a Countdown/Schedule for Room
* Fully White-label Virtual Classroom
* Limit the max allowed participants for a room e.g (5, 10, .. etc) both on a per room and per page basis. This can allow you to conduct a 1:1 or group session
* Upload your brand logo that is visible in the BBB room
* Customize the room background-color as per your brand color
* Change welcome message that is displayed in the Public Chat section of the room
* Customize thank you message when the user leaves the meeting
* Pre-upload your presentation (ability to upload both globally and per room basis)

**[Get Pro Version](https://elearningevolve.com/products/video-conferencing-with-bigbluebutton-pro/)**
### Video Guide ###
[![Video Guide](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-youtube.jpeg)](https://youtu.be/laClYKDxLcw)
[youtube https://www.youtube.com/watch?v=laClYKDxLcw]

### How-Tos ###
* [How to join BigBlueButton Room from WordPress](https://elearningevolve.com/blog/how-to-join-bigbluebutton-room-from-wordpress/)
* [How to limit number of users for BigBlueButton Room on WordPress](https://elearningevolve.com/blog/how-to-limit-number-of-users-for-bigbluebutton-room-on-wordpress/)

### BigBlueButton Server ###
To get up and running in no time with a managed BigBlueButton hosting provider please refer to our [Recommended BBB hosting providers](https://elearningevolve.com/blog/bigbluebutton-hosting).

For further queries feel free to [contact us](https://elearningevolve.com/contact/).

## Installation ##

Here's an overview of the installation.

   1. Log in as an admin and click on the Plugins menu on the sidebar.
   1. Click Add new.
   1. In the search bar enter "Video Conferencing with BBB" and click search plugins.
   1. When you find the plugin called Video Conferencing with BBB by eLearning evolve click the install now link.
   1. Activate the Plugin.
   1. Click on BBB Rooms in the sidebar and click on Server Settings.
   1. Fill out the URL of where the BigBlueButton server is running (be sure to add /bigbluebutton/ to the end of the URL) and it's salt. Then click on Save.
   1. Click on BBB Rooms in the sidebar.
   1. Add a new room and publish it.
   1. Click on BBB Rooms in the sidebar again and copy the token of your new room.
   1. Click on widgets under the Appearance menu.
   1. Find the BBB Rooms Widget. Then click and drag it to either the right, content or footer windows on the right of the screen depending on where you wish the BBB Rooms widget to appear.
   1. Enter the token you copied earlier into the widget and save it.
   1. You are ready to begin creating meetings and holding conferences.

## Frequently Asked Questions ##

**How do I create meetings?**
After activating the plugin, click on "BBB Rooms" and "Add New" and give the meeting a title and fill out the room details.

**How to display room join form?**

* By default, each room will be on its own page, with the permalink listed under BBB Rooms -> All Rooms. 
* A single BBB Room can also be inserted into any post/page using the **[bigbluebutton] shortcode** with a specified token in the shortcode in the format,
`[bigbluebutton token=z2xxx]`
* There is also an option to insert multiple Rooms to any post/page where the user can select a specific room to join. To acheive this insert multiple tokens in the shortcode in the format,
`[bigbluebutton token=z2xxx,z2yyy]`
* Users join meetings using a join room form. This form can be shown on a site as a sidebar element or as a page/post.
* For setting up in the sidebar, add the BBB Rooms widget, as you do with any other widget, dragging the box to the position you want it to be in.

**How to join the BBB room?**
Once you display the room join form on your preferred page or section on your site. Simply, share the website link of your page with your participants and they can join the BBB room directly from there.

**How can users view recordings?**

By default, the recordings display under each room created under BBB Rooms -> All Rooms.

* To place recordings on a separate post/page, use the shortcode `[bigbluebutton type=recording]`, with the room token of the desired recording e.g:
`[bigbluebutton type=recording token=z2xxx]`
* To place multiple recordings on a separate post/page, use the shortcode `[bigbluebutton type=recording]`, with the room tokens of the desired recording e.g:
`[bigbluebutton type=recording token=z2xxx,z2yyy]`

**How to let users select a specific BBB room to join from frontend**

Insert the token of your BBB Room that you would like the users to select from in the shortcode with this format, `[bigbluebutton token=z2xxx,z2yyy]`

**Which users are required to enter the Name and Access Code on room join form?**
* *For non-logged in users:* The Name & Access Code will be always required.
* *For logged-in users:* The login username will be taken as their Name. The Access Code field does not displays for these user roles **administrator, author, editor, contributor, subscriber**. Any other user role will be required to enter the Access Code.
* *For logged-in users:* To remove the Access Code requirement for a user role, you can customize the particular user role by adding the capability, **join_as_viewer_bbb_room**.

**How can I change the capability/permissions of a user role?**

You can install the [**"User Role Editor plugin"**](https://wordpress.org/plugins/user-role-editor/) and update the capabilities/permissions from **"Users" > "User Role Editor"**.
[See User Role Plugin Usage Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-user-roles-editor.jpeg)

**How to allow a user role to create BBB Rooms from the Dashbaord?**

See our detailed [step by step guide](https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/) to learn this.

**How to assign a WordPress user role as the moderator for the BBB room?**

* By default, the user who has created a BBB room and will always join their room as a moderator, this does not apply to others'rooms.
* The WordPress site administrators have the moderator access for all BBB Rooms.
* Additionally, you can customize your site user roles to add the capability,  **join_as_moderator_bbb_room** for your preferred role to grant them the moderator access for all BBB Rooms like the administrator.

**How to Restrict number of users or max participants for all rooms or per room?**
This feature is available in our [Pro plugin](https://elearningevolve.com/products/bigbluebutton-wordpress-pro/). You can limit the max participants for all the rooms from *BBB Rooms -> Settings -> Room Config*
[See Global Participant Limit Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-limit-participant-global.jpeg)

You can also override the global settings or set a different limit for each page by setting the max participants param with each shortcode that is added to a page.
[See Shortcode Level Limit Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-limit-participant-shortcode.jpeg)

**Where do administrator of the room login to their page/ room to schedule and manage meetings**
They need to login to their WordPress dashboard https://mywpsite.com/wp-admin
from the dashbaord they can manage the room from BBB Rooms menu.

**How to schedule a BBB room meeting**
This feature is available in our [Pro plugin](https://elearningevolve.com/products/bigbluebutton-wordpress-pro/) where the Room admin can set a date/time of room meeting to start for each of the rooms.
[See BBB Room Countdown Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-countdown-setting.jpeg)

**I want to edit my recordings. How do I do that?**

If a user has the capability to manage recordings, they will see a pencil icon next to the recording name and description. Click on the icon to start editing, and press enter to submit. A user can cancel editing by pressing the ESC key.

To allow a user role to manage recordings add the capability, **manage_bbb_room_recordings**.

## Screenshots ##

1. Features: Audio - built-in and dial-in numbers (in some regions), Video - low, medium, and high resolution, Screen sharing, Chat (public/private), Upload slides (any PDF, Microsoft PowerPoint, Word, or Excel), Whiteboard annotation, Multi-user whiteboard, Breakout rooms, Shared notes, Raise hand, Emojis, Polling, Share external video, Recordings, Browser and Mobile Friendly HTML5 interface, runs on desktop, laptop, and mobile devices using iOS 12.2+ and Android 6.0+.
2. BBB Meeting Room.
3. BBB Rooms are a Content Type that has its own view.
4. BBB Rooms can be embedded into Posts, Pages, and other Content Types using shortcodes.
5. Multiple rooms can be accessed from the same Page or Post.
6. Server settings define where the meetings are hosted.
7. BBB Rooms can be managed through the Administrator Dashboard.
8. BBB Rooms can also be organized using Categories.

## Changelog ##
### 1.4.2 ###
* Added: New capability add_bbb_rooms to allow Add New rooms access to admins and users with this new capability
* Added: Update capability permissions on each plugin update to prevent the need for activate/deactivate plugin
* Updated: Performance improvement with code optimization

### 1.4.1 ###
* Updated: Remove custom fields from BBB Rooms -> Add New
* Added: New capability can_limit_user_in_bbb_rooms the room limit option will show only to admins and users with this new capability
* Added: New tutorial [How to allow instructors or users to manage BigblueButton Rooms on WordPress](https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/) in plugin settings page

### 1.4.0 ###
* Added: Tutorials section on plugin settings page
* Added: Shortcode guide section on settings page for all available plugin shortcodes
* Updated: Restrict settings page access only to Admin level users
* Updated: BBB multiple room select shortcode layout to align with the join form
* Updated: Compatibility for Room level limit feature addition in Pro plugin
* Fixed: Access code error message does not display when codes updated while meeting is running

### 1.3.1 ###
* Fixed: Error Call to undefined function get_current_screen()

### 1.3.0 ###
* Added: Automatically create a default Home Room under BBB Rooms -> All Rooms admin page
* Added: Ability to start meeting from BBB Rooms -> All Rooms
* Added: Ability to filter rooms by category from BBB Rooms -> All Rooms\
* Added: Help text on BBB Rooms -> All Rooms page
* Updated: Admin view of All Rooms page

### 1.2.1 ###
* Added: updated FAQ section and added new answers
* Updated: Removed restriction for preview of unpublished rooms
* Fixed: BBB Room create/edit permissions granted to non-admin user roles
* Fixed: Permissions are not assigned on plugin activate
[Action needed] Please deactivate and activate the plugin to apply the above fixes

### 1.2.0 ###
* Added: Compatibility for per shortcode max participant room limit in Pro plugin
* Added: Compatibility for pre upload presentation (global and per room basis) in Pro plugin
* Added: Compatibility for the ability to customize background color for the room in Pro plugin
* Added: Shortcode usage guide on the plugin settings page

### 1.1.6 ###
* Fixed: You did not pass the checksum security check error on room join with BBB On Demand Server

### 1.1.5 ###
* Fixed: The page can't be found error when viewing a BBB room
[Action needed] Please deactivate and activate the plugin to apply this fix

### 1.1.4 ###
* Added: compatibility for the max room participant limit feature added in Pro plugin

### 1.1.3 ###
* Added: compatibility for the room start time & countdown feature added in Pro plugin
* Fixed: Super admin can not login WP multisite after activating the plugin

### 1.1.2 ###
* Added: Our [Pro version](https://elearningevolve.com/products/bigbluebutton-wordpress-pro/) release notice on the plugin settings page

### 1.1.1 ###
* Updated: Removed the need to assign activate_plugins user permission for admin BBB Rooms menu.
* Added: Use capability "publish_bbb_rooms" for admin BBB Rooms menu access by any user role.

### 1.1.0 ###
* Updated: Replaced the older test server credentials of Blindside Networks by [Bigbluebutton.host](https://bigbluebutton.host/) test server in plugin settings.
* Fixed: Blindside Networks test server not working anymore, not able to join rooms.
* Updated: Minor style changes, room join form center aligned with the page.

### 1.0.4 ###
* Added: [Our Recommended BBB hosting providers](https://elearningevolve.com/blog/bigbluebutton-hosting) blog in plugin settings.
* Compatibility: Tested with WP version 5.9.1.

### 1.0.3 ###
* Fixed: EndPoint URL & Shared Secret/Salt settings not saved and shows error sometimes.
* Improvement: Make error messages & recording page button text more user-friendly.
* Improvement: Added new hooks in plugin.

### 1.0.2 ###
* Tested: compatibility with WordPress v5.8.3.
* Improvement: Added new hooks in plugin.
* Improvement: Security enhancement on recordings section.

### 1.0.1 ###
* Fixed: plugin warning messages on WP dashboard.
* Improvement: Readability of plugin conflict messages.

### 1.0.0 ###
* Improvement: Security enhancement on room join page.
* Improvement: Tested with WP version 5.8.2.
* Improvement: Ability to copy the shortcode from the BBB Rooms listing page.
* Improvement: Use HTTPS version for the test bigbluebutton endpoint

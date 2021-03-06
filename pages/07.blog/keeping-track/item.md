---
title: 'Keeping Track'
media_order: IMG_5308.JPG
published: true
taxonomy:
    category:
        - edci614
        - online
    tag:
        - open
        - Grav
hide_git_sync_repo_link: false
hero_classes: 'overlay-dark-gradient text-light'
hero_image: IMG_5308.JPG
header_image_credit: 'Photo Credit: Colin Madland'
blog_url: /blog
show_sidebar: true
show_breadcrumbs: true
show_pagination: true
hide_from_post_list: false
---

I'm making an effort to be as open as possible during this PhD. In doing so, I've moved most of my draft work to [GitHub](https://github.com/cmadland), and I'm publishing most stuff from there to [Grav](https://grav.madland.ca).

===

A few times, I've not only published a post, but also publicized it on Twitter. Typically those posts get a little love, but this isn't revolutionary work, yet.

One piece of advice that I've received and am trying to implement is to 'write while I read' (HT to [Inba](https://twitter.com/InbaKehoe) for that tidbit). The idea is to not just read articles and hope that I can remember what is where, but to summarize and catalog what I am reading while I am reading it. This is one of those habits of mind that is maybe a little tedious to implement and maintain, but the benefit comes later when I need to sift through it all and make some sense of everything.

For my first course, I've been composing these reviews as posts on my blog, but that doesn't seem to me to be a very good place because I am going to essentially need a searchable database.

One option to create a database like this is to build a spreadsheet and add details like  abstracts, keywords, and notes on methods and conclusions. But spreadsheets aren't designed for larger chunks of text like abstracts and summaries. Those make spreadsheets terribly unwieldy with all that scrolling. Nobody *really* likes spreadsheets.

A second thought was to use [Zotero](https://zotero.org). After all, Zotero is already a database of articles, it's searchable, has fields for notes, and a whole bunch of other things. What it doesn't have is a robust text editor to compose notes. And the search features are a little annoying as they will only search the active folder. If you run a search in the wrong folder, you have to start again. Maybe that is nitpicky. Fight me.

Another option would be to copy [what Audrey Watters does with her datasets and connect a front-end page (she uses Github pages)](http://data.hackeducation.com/2017/07/28/how-to) like Grav with a Google spreadsheet in the back-end. I took a look at her post on how to set that up and worked through most of it, but ran into troubles translating her method (GH Pages) to Grav. Plus...spreadsheets...and Google. bleh

The idea that I did glean from Audrey's method is to have separate sites for separate uses. That started to make some sense, so I decided to fire up a [Grav site](https://grav.madland.ca/articles), connect it to a GH repo with the shiny new GitSync 2.0 plugin (nice work on that Grav!), and see how that might work.

I decided to install a ['Learn2 with GitSync' skeleton](https://demo.hibbittsdesign.org/grav-learn2-git-sync/) (Huge thanks to [Paul Hibbitts](https://twitter.com/hibbittsdesign) for that) from [Reclaim's](https://reclaimhosting.com) super-slick install process. Learn2 is a good way to get a nice clean ToC and easy navigation, so I figured that would be a good place to start.

I have decided to use 'Chapters' as 'Topics' and then each article will be a single sub-page within their respective topics. For now, I have two topics, 'Open Education' and 'General Education', and the beginnings of two articles reviewed under 'Open Education'.

I don't yet know what information I'll include on each review, but it will almost certainly include the full bibliographic info in APA, a link, abstract, keywords, summary of methods and other notes and conclusions. I'll also likely include a brief narrative around the utility of the article for my research, maybe questions I have, or related articles.

Once I have a decent template created, I'll just have to duplicate that folder in the repo, change a bit of the metadata and YAML, and I'll be off to the races. Grav makes it super easy to reorder items, so I'll be able to keep them in alpha order by author.

One thing that I didn't anticipate, but which makes the Learn2 theme an absolutely brilliant choice is the search feature. All I have to do is start typing a query in the field and Grav filters everything out that doesn't have that item anywhere in it. I can search by author, method, keyword, title...anything, and it will update live. Now, I don't know how fast it will be when there are a few hundred posts in there, but, for now, it's a game changer.

[Here's the link again.](https://grav.madland.ca/articles)

!!!! Update (Oct 25/18): I've since activated the TNTSearch plugin on Grav. Bombdiggity.

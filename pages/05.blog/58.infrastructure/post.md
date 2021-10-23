---
title: 'Personal Knowledge Infrastructure'
published: false
taxonomy:
    tag:
        - thinking
hide_git_sync_repo_link: false
hide_hypothesis: true
hero_classes: 'overlay-dark-gradient text-light'
hero_image: riverside.jpg
header_image_credit: 'Colin Madland'
header_image_creditlink: 'https://www.flickr.com/photos/colinmadland/51396635809/in/datetaken/'
blog_url: /blog
show_sidebar: false
show_breadcrumbs: false
show_pagination: false
hide_from_post_list: true
root_of_blog: true
content:
    items:
        - '@self.children'
    limit: 10
    order:
        by: date
        dir: desc
feed:
    limit: 10
---

Higher Ed is sometimes slow to change, which is, in many cases, a feature, not a bug. But when the pace of change in the broader society is so fast and constantly accelerating, it can lead to problems that linger ([a word which will never not trigger this song for me](https://youtu.be/G6Kspj3OO0s)) without resolution.

Back in 2009, [Gardner Campbel](https://twitter.com/GardnerCampbell) published one of the most influential articles in my professional journey,[*A Personal Cyberinfrastructure*](https://er.educause.edu/articles/2009/9/a-personal-cyberinfrastructure). In it, Campbell argues that the web shouldn't be a series of templates and blanks to fill in, but a place to tinker, or, as I like to phrase it, muck about. He laments, however, that one of the things that many faculty have neither the time (nor inclination) to do, is tinker with/on the web, leading to a gap between the opportunities that modern learners have to learn and the capacity of faculty to even lead them to the fountain. This is a gap that has lingered [more Cranberries](https://www.youtube.com/watch?v=6Ejga4kJUts) as evidenced by the fact that clicking the link to Campbell's blog at the bottom on the EDUCause article shows [his most recent post, 12 years after the original,](https://www.gardnercampbell.net/blog1/cpanels-and-domains-two-takes/) is still focused on the same idea.

But this isn't where the impulse for this post came from...that would have been [this post](https://bodong.me/post/2021-10-knowledge-infrastructures/) by [Bodong Chen](https://twitter.com/bod0ng), which I found looking for a way to integrate [hypothes.is](https://hypothe.is) with a [bookdown site](https://bookdown.org), [like this](https://bookdown.org/chen/snaEd/). As one might expect, when open tools are used, there is someone out there who has sorted out how to get them to play nicely.

Back to infrastructure...

Reading Chen's post on infrastructure immediately reminded me of Campbell's, (which led me to Campbell's new one), and has me tripping back through how I have built a personal knowledge infrastructure over the last few years by simply mucking about with web tools. I don't have any formal education in computer science (my undergrad degrees are in physical education, then an MEd, and now working on a PhD in education). I've written about a couple iterations on my workflow and infrastructure [here](https://madland.ca/blog/interviewing-my-domain) and [here](https://madland.ca/blog/lit-workflow) and I think I have a thread on Twitter, but have you ever tried to search your Twitter timeline?  

i find that I am moving more and more towards a workflow that prioritizes creating content in text files and uses Markdown for styling (like this whole site [as well as my new Bookdown site](https://cmadland.github.io/assessment)). One huge advantage of MD is that it is platform agnostic, so the content I have here on a Grav site can literally be copy/pasta'd into a bookdown site and published with very few, if any, edits aside from deleting the frontmatter that Grav uses. I recognize that learning to use a different infrastructure can be challenging, but, as Chen put it:

> To change culture in science we need to change infrastructure. 

So when I see recommendations [like this one](https://twitter.com/ClaytonBurnsPhD/status/1445123725678964740?s=20), I see the need for a change ininfrastructure. I posted about a [possible collaborative workflow here](https://madland.ca/blog/git-grav-nerdery). 

We [@EdTechUVic](https://twitter.com/edtechuvic) have been working towards empowering learners to build their own knowledge infrastructures in the 5 [(soon to be 6)](https://www.uvic.ca/calendar/undergrad/index.php#/courses/rkpYsIdES?bc=true&bcCurrent=Learning%20in%20an%20Open%20and%20Connected%20World&bcGroup=Curriculum%20and%20Instruction%20Studies%20(EDCI)&bcItemType=Courses) undergrad courses that form a core of EdTech courses at UVic. I am currently teaching a course called [*Learning Design*, EDCI335](https://edtechuvic.ca/edci335) where we host the course materials on an open WordPress site and invite learners to create their own WordPress sites on the [Open EdTech Cooperative site, opened.ca](https://opened.ca). It certainly takes some time (usually a couple weeks) to orient learners to a new workflow, but it is very much worth the effort. Instead of learners losing their community to an abandoned, archived, or deleted LMS site, they get to use a single site that is under their control to curate their learning in accordance with their personal privacy preferences.

I've taught several sections of EDCI335, and a few of [EDCI339](https://edtechuvic.ca/edci339), but this term was the first that I noticed several learners who were asking about being able to use their 'old' site for 335. Of course, the answer was a hearty 'Of course!'. There are 1 or 2 in this cohort who have menu links for all 5 current EDCI courses indicating a curated site of all of their learning over these courses.

If I were to recommend a set of tools for learners to build their own knowledge infrastructure, it might include things like:
- [cPanel (which opens doors to...)](https://www.cpanel.net)
  - [WordPress](https://wordpress.org)
  - [Grav](https://getgrav.org)
  - [MediaWiki](https:..mediawiki.org)
- [Markdown (more doors...)](https://daringfireball.net/projects/markdown/)
  - [Notion](https://notion.so)
  - [Obsidian](https://obsidian.md)
  - [Grav, again]((https://getgrav.org))
  - [bookdown](https://bookdown.org)
- [git (in whatever GUI flavour...)](https://git-scm.com/)
  - [GitHub](https://github.com)
  - [GitLab](https://gitlab.com)
  - [Gitea](https://gitea.io)
- [Zotero](https://zotero.org)
- [Hypothes.is](https://hypothes.is)

I'm sure there are others I would recall if I didn't have to vacuum the house, but these suggestions based on broad categories rather than discreet tools, would be an amazing starting point to allow learners to curate, build, and iterate on their findings over the course of a university career and beyond.
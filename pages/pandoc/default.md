---
title: 'Pandoc Info'
hide_git_sync_repo_link: false
hide_hypothesis: false
hide_page_title: '0'
visible: false
---

I'm using a command line program called Pandoc to convert files from `.md` in GitHub and Grav to `.docx` in Werd.

The following code gets me from here to there

### From `.md` to `Werd` w/ bib
```
pandoc 2page-final.md -s  --bibliography /Users/cmadland/pandoc/BBL_Library.bib --csl /Users/cmadland/pandoc/apa.csl -f markdown -t docx -o 2pagetest-final.docx
```

### From `.md` to `gfm` w/ bib

```
pandoc 2page-final.md -s  --bibliography /Users/cmadland/pandoc/BBL_Library.bib --csl /Users/cmadland/pandoc/apa.csl -f markdown -t gfm -o 2pagetest-final.md
```

### from `.md` to `.pdf` w/ bib

```
pandoc  -s  --bibliography /Users/cmadland/pandoc/BBL_Library.bib --csl /Users/cmadland/pandoc/apa.csl -f markdown -t latex -o test.pdf 2page-final.md
```

From `docx` to `md`
```
pandoc CV20210206.docx -s -o CV20210206.md --to=gfm --wrap=none --extract-media=[DIR]
```

[Workflow blog post](http://u.arizona.edu/~selisker/post/workflow/)

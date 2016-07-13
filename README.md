Background
==========

The Space Radiation Analysis Group (SRAG) has a public website (http://srag.jsc.nasa.gov) as well as a private internal web. This internal web is used to display instrument graphs important for radiation monitoring and data analysis, command logs and communication platforms between inner SRAG groups, and a myriad of data collection and analysis tools that have been developed over many years. The site was developed with ColdFusion, an Adobe web application development platform that supports the entire structure of the website, generates pages, manages group accounts, and queries databases. Currently, the entire site is hosted on two of SRAG’s personally maintained servers, and SRAG performs monthly maintenance work, including updating software packages, running federally required security scans, and upgrading server hardware systems.
The basis of this project comes from the opportunity to host this site with WESTPrime instead, one of NASA’s agency-wide IT service contractors. This is desirable because it provides many benefits to the department:

-   The site was originally designed to operate on two servers, which is likely no longer necessary. Reorganizing the architecture of the site for WESTPrime hosting reduces complexity for future development and requires fewer resources to host.

-   SRAG would no longer need to perform monthly maintenance work, saving both time and hassle.

-   SRAG can focus on improving the content and functionality of the site, which ultimately improves the department’s output as a whole.

The project, essentially, is to work on porting the site in its current state, to a new content management system (CMS) called Drupal, which WESTPrime can host. Aside from compatibility with WESTPrime, Drupal offers a chance to build a more flexible, compatible, and developer-friendly site. Currently, Drupal is rather foreign to SRAG, so I am expected to explore and research Drupal and implement pieces of key functionality or explain why Drupal is not a good choice to transfer to. If successful, SRAG will not only have key parts of its website working in Drupal, but also the knowledge and resources to transfer the rest of the site.

Objectives
==========

This project begins from scratch with the installation of a Drupal server. Completion of the project is the research and implementation of the following within Drupal:

1.  Grouping Functionality

    -   research and determine how to implement grouping without account sharing

    -   establish groups: SRAG, BME, BMEOPS, DOSE, FLT, GOV, IP, RP.

    -   establish test user accounts organized in corresponding groups

    -   users see and have access to different pages based on group

2.  Database Functionality

    -   research and determine how to pull/query from a database

    -   implement pulling/querying by mimicking internal home page status messages

    -   research and determine how to push to a database

    -   research and determine how to periodically and automatically run processing scripts

    -   implement pushing and scheduled script runs by implementing the ISS Radiation Instruments Status page

3.  Instrument Displays

    -   research and determine how to support JavaScript applet, database calls, and other functions required by the instrument displays (including scheduled script runs)

    -   implement the ISS TEPC 24-Hour Display page

4.  Webpage Generation

    -   ColdFusion pages generate HTML webpages themselves; research and determine how to mimic this generative process in Drupal

    -   implement webpage generation by recreating a home webpage in Drupal

Because of the nature of the project, its expectations are likely to morph as it progresses, and project requirements may be added, removed, or tweaked. Preliminary work suggests that the functionality is possible, but feasibility and practicality also need to be considered. As an understanding of Drupal develops, the approach to implementation might change. Completion of the project as outlined implies that SRAG can easily and confidently migrate the remainder of its website into the Drupal environment.

Approach
========

Running into difficulties and obstacles is of crucial importance in this project because any single barrier, if large enough, could be reason enough to argue against transferring to Drupal. If this should happen, it should be discovered earlier rather than later. Therefore, a breadth-first work flow is desirable. In other words, it is better to work a little bit on every functionality than to attempt to complete any single major functionality first. Furthermore, it is beneficial to first research as much as possible to gain an understanding of feasibility for everything before attempting full implementation of any single item.
It is difficult to identify specific challenges, as I will be looking for these difficulties in the first place. How long each small step takes is virtually unknowable, being dependent on diligence, fast internet, and a little bit of luck. Obvious milestones include discovery of feasibility (or infeasibility), implementation of small specific functions, and implementation of overall functions.
I will be the sole individual working on the project, and the project does not depend on anyone else (except the mentor). I will be running Bitnami Drupal 7 on a VirtualBox Ubuntu 14 Linux machine within a NASA Windows 7 Desktop to host a Drupal server for experimentation and implementation. This is already set up.

Project Schedule
================

As touched on in the **Approach** section, it is incredibly difficult to propose a schedule accurate enough to be useful. However, the previous sections detail the specifics of the project to be completed. I will work on the Flex schedule – 9 hours a day, alternating weekly between 8-hour Fridays and Fridays off. I will simply work on one of the Flex Fridays to make up for Independence Day, which my mentor and I will both have off.

References
==========

1.  SRAG public website: *http://srag.jsc.nasa.gov*

2.  NASA WESTPrime: *http://www.hq.nasa.gov/office/itcd/WESTPrime.html*

3.  ColdFusion: *http://www.adobe.com/products/coldfusion-family.html*

4.  Drupal: *https://www.drupal.org*

5.  Bitnami Drupal VM: *https://bitnami.com/stack/drupal/virtual-machine*

6.  Mark Langford: partial draft of his project description

7.  Mark Langford: thoroughly discussed project expectations

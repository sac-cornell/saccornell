BEGIN TRANSACTION;

-- Users Table
CREATE TABLE 'users' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'un' TEXT NOT NULL UNIQUE,
  'pw' TEXT NOT NULL
);

INSERT INTO 'users' (un, pw) VALUES ('admin','$2y$10$ApdL9aarngWgutFaJjHnaua6Pht6ELnNnUjjali8/BQxI8ZHeGjxe'); -- password: saccornell

-- Sessions table
CREATE TABLE 'sessions' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'user_id' INTEGER NOT NULL,
  'session' TEXT NOT NULL UNIQUE
);

CREATE TABLE 'seeds' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'image_name' TEXT NOT NULL,
  'file_ext' TEXT NOT NULL
);

-- Resource table

CREATE TABLE 'resources' (
   'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
   'ext' TEXT NOT NULL,
  'title' TEXT NOT NULL UNIQUE,
   'description' TEXT,
   'link' TEXT NOT NULL,
   'link2' TEXT,
   'citation' TEXT,
   'type' TEXT NOT NULL
 );

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (1, 'jpg','Asian American Studies Program', 'A national resource center on historical and contemporary South Asia.
The South Asia Program (SAP) serves as an interdisciplinary hub for Cornell students, faculty, staff, community members, and academic visitors. SAP has been designated by the U.S. Department of Education as a Title VI, South Asia National Resource Center (NRC), one of just seven NRCs in the U.S.
', 'http://asianamericanstudies.cornell.edu/','http://asianamericanstudies.cornell.edu/sites/aas/files/Wong_0.jpg', 'academic');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (2, 'jpg','South Asia Program', 'The program affords students an opportunity to develop a multidisciplinary approach to the study of Asians in the hemispheric Americas. The course of study stresses developments within the United States, but also underscores the transnational and comparative contexts of Asian America and the fields connections with African American, American Indian, Latino, and Womens Studies', 'https://sap.einaudi.cornell.edu/','https://sap.einaudi.cornell.edu/about-us' ,'academic');

INSERT INTO resources (id, ext, title, description, link, link2, citation, type) VALUES (3, 'jpg','Adhikaar for Human Rights & Social Justice', 'Adhikaar, meaning rights in Nepali, is a New York-based nonprofit organization working with Nepali-speaking community to promote human rights and social justice for all.', 'http://www.adhikaar.org/','https://jacksonheightspost.com/local-activist-groups-to-host-cop-i-c-e-watch-training-workshop-on-thursday','https://www.facebook.com/adhikaar/photos/a.439321663252/10154866766153253/?type=1&theater' ,'external');

INSERT INTO resources (id, ext, title, description, link, link2, citation,  type) VALUES (4, 'jpg','Chhaya CDC', 'Based in Jackson Heights, Queens, New York, Chhaya Community Development Corporation (Chhaya)—meaning “shelter or shade” is dedicated to creating stable and sustainable communities by increasing civic participation and addressing the housing and community development needs of New Yorkers of South Asian origin and their neighbors.', 'http://www.adhikaar.org/', 'https://www.youtube.com/watch?v=TEguAEeg9So','https://www.facebook.com/chhayacdc/', 'external');

INSERT INTO resources (id, ext, title, description, link, link2, citation,  type) VALUES (5, 'jpg','DRUM – South Asian Organizing Center
', 'DRUM – South Asian Organizing Center is a multigenerational, membership led organization of low-wage South Asian immigrant workers and youth in New York City.', 'http://www.drumnyc.org/', 'https://jacobinmag.com/2019/02/amazon-headquarters-new-york-queens-organizing
','http://www.drumnyc.org/wp-content/uploads/2012/10/1913453_780030098721929_1776451770490626680_o.jpg' ,'external');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (6, 'jpg','Sakhi for South Asian Women', 'Sakhi for South Asian Women exists to end violence against women. We unite survivors, communities, and institutions to eradicate domestic violence as we work together to create strong and healthy communities. Sakhi uses an integrated approach that combines support and empowerment through service delivery, community engagement, advocacy, and policy initiatives.
', 'https://www.sakhi.org', 'https://pbs.twimg.com/profile_images/1079493372098854914/rDu3oozy_400x400.jpg', 'external');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (7, 'jpg','SAALT', 'South Asian Americans Leading Together (SAALT) is a national, nonpartisan, non-profit organization that fights for racial justice and advocates for the civil rights of all South Asians in the United States. Our ultimate vision is dignity and full inclusion for all. We fulfill our mission through:
Advocating for just and equitable public policies at the national and local level;
Strengthening grassroots South Asian organizations as catalysts for community change;
Informing and influencing the national dialogue on trends impacting our communities. SAALT is the only national, staffed South Asian organization that advocates around issues affecting South Asian communities through a social justice framework. SAALT’s strategies include conducting public policy analysis and advocacy; building partnerships with South Asian organizations and allies; mobilizing communities to take action; and developing leadership for social change.', 'http://saalt.org/', 'http://saalt.org/notorious-el-paso-facility-continues-abuse-of-south-asian-asylum-seekers/', 'external');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (8, 'jpg','SALGA NYC', 'SALGA NYC’s mission is to enable community members to establish cultural visibility and take a stand against oppression and discrimination in all its forms. We pledge to encourage leadership development, provide multi-generational support, work towards immigration advocacy, address health issues such as HIV / AIDS, and foster political involvement in the interest of creating a more tolerant society.', 'http://www.salganyc.org/','https://www.facebook.com/211460882227087/photos/a.827488357291000/965842043455630/?type=1&theater','external');

INSERT INTO resources (id, ext, title, description, link, link2, citation, type) VALUES (9, 'jpg','Sapna NYC', 'Sapna NYC promotes the health, social, and economic empowerment of New York City’s South Asian community through a learning-based partnership between families, health professionals and other stakeholders.', 'https://www.sapnanyc.org', 'https://www.nytimes.com/2018/12/11/neediest-cases/immigrant-pakistan-language.html','https://www.facebook.com/SapnaNYC' ,'external');

INSERT INTO resources (id, ext, title, description, link, link2, citation, type) VALUES (10, 'png','South Asian Council for Social Services', 'South Asian Council for Social Services mission is to plan, provide, support and advocate for a continuum of programs addressing the social service needs of the underserved South Asian and Indo-Caribbean communities of New York City.', 'https://www.sacssny.org/', 'https://qns.com/story/2018/07/07/south-asian-council-for-social-services-received-700k-grant/','https://www.facebook.com/sacssny/' ,'external');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (11, 'png','South Asian Health Initiative', 'The South Asian Health Initiative (SAHI) is working to increase awareness and treatment of the most common health problems affecting the South Asian immigrant community in New York City, including oral cancer, diabetes, high blood pressure, and high cholesterol. We collaborate with a wide range of community- and faith-based organizations', 'https://www.mskcc.org/departments/psychiatry-behavioral-sciences/immigrant-health-disparities-service/working-diverse-communities/south-asian-health-initiative','https://www.facebook.com/sloankettering' ,'external');

INSERT INTO resources (id, ext, title, description, link, link2, citation, type) VALUES (12, 'png','South Asian Youth Action', 'SAYA!’s mission is to create opportunities for South Asian youth to realize their fullest potential. We deliver culturally sensitive services and support to help make this mission a reality.', 'http://www.saya.org/','http://www.qchron.com/editions/south/richmond-hill-hs-is-standing-tall/article_cd4796ca-1e0f-5a10-8b0e-058f0134d2a0.html','https://www.facebook.com/southasianyouthaction/' ,'external');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (13, 'png','South Asian American Digital Archive', 'SAADA creates a more inclusive society by giving voice to South Asian Americans through documenting, preserving, and sharing stories that represent their unique and diverse experiences.', 'https://www.saada.org', 'https://www.facebook.com/southasianyouthaction/', 'external');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (14, 'png','South Asian Millennials Conference', 'The South Asian Millennials Conference, or SAMC, is an annual conference intended to foster thought, dialogue, and community between South Asians and South Asian-Americans across the United States. Each year, hundreds of South Asians and South Asian-Americans gather for a day of panels, workshops, and activities led by South Asians on various topics relating to South Asia and its diaspora. SAMC is a collaborative effort between students from Yale University and Columbia University.', 'https://sites.google.com/yale.edu/samillennialsconference/home', 'https://sites.google.com/yale.edu/samillennialsconference/home', 'external');

INSERT INTO resources (id, ext, title, link, citation, type) VALUES (15, 'jpg', 'Asian American Learning Center',
'https://dos.cornell.edu/asian-asian-american-center','https://www.facebook.com/CornellA3C/photos/a.10150100798519768/10155243975464768/?type=1&theater' ,'academic');

INSERT INTO resources (id, ext, title, description, link, citation, type) VALUES (16, 'png', 'ALANA',
"South Asian Council is the fifth umbrella organization — an organization that provides funding and support to its member organizations — under the African Latino Asian Native American Students Programming Board.
In addition to the SAC, ALANA includes <a href='http://orgsync.rso.cornell.edu/show_profile/72813-black-students-united
'>Black Students United</a>, <a href='http://orgsync.rso.cornell.edu/show_profile/72908-la-asociacin-latina'>La Asociacion
Latina</a>, <a href='https://aiisp.cornell.edu/student-life/native-american-student-organizations/native-american-students-cornell/'>Native American Students at Cornell</a> and the <a href='http://www.cornellcapsu.org/about-us'>Cornell Asian and Pacific
Islander Student Union</a>.",
'http://orgsync.rso.cornell.edu/org/alana','https://www.facebook.com/ALANAInterculturalBoard/photos/a.741476579222277/1617909261579000/?type=1&theater', 'academic');


CREATE TABLE 'members' (
   'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
   'file_name' TEXT NOT NULL,
   'ext' TEXT NOT NULL,
   'name' TEXT NOT NULL,
   'position' TEXT NOT NULL,
   'year' INTEGER NOT NULL,
   'major' TEXT NOT NULL,
   'minor' TEXT,
   'hometown' TEXT,
   'description' TEXT,
   'involvement' TEXT
 );

INSERT INTO members (file_name, ext, name, position, year, major, minor, hometown, description, involvement) VALUES ('kumar', 'jpg', 'Kumar Nandanampati', 'Co-president + Co-director of the South Asian Mentorship Program', 2020, 'Information Science', 'Asian-American Studies', 'Duluth, Georgia', 'I envision a New Brown America where Desi-Americans realize that enduring racism and prejudice is not a rite of passage in America, and that all Desi-Americans, including women, Muslims, immigrants, the LGBTQ community, disabled, and other minorities within our communities, have the nerve to believe that they are equals in this country.', 'Meinig Scholar, Business Analyst at Cornell Consulting, VP of Operations at Pi Sigma Epsilon Business Fraternity, E-Board member of Hindu Student Council, former dancer on Big Red Raas, former facilitator for Intergroup Dialogue Project');
INSERT INTO members (file_name, ext, name, position, year, major, hometown, description, involvement) VALUES ('aashka', 'jpg', 'Aashka Piprottar','Co-president + Director of Interfaith Mock Shaadi', 2020, 'Hotel Administration', 'Fort Wayne, Indiana', 'I envision a future where all desis can create, live out, and celebrate their intersectional identities and narratives on their own terms, without internal and external community expectations of what it means to be “brown”, “desi”, “ABCD”, etc. I envision a future where we are properly represented in POC coalitions, in LGBTQ+ spaces, in all relevant conversations and dialogues and where we work together with our unique identities and privileges to further the fight for equality for ALL desis.', 'Cornell Hospitality Consulting, Meinig Family Cornell National Scholar, Student Activities Funding Commissioner, Cornell Social Media Ambassador, member of Female Leadership in Hospitality, former CMUNC Staffer');
INSERT INTO members (file_name, ext, name, position, year, major, description, involvement) VALUES ('katha', 'jpg', 'Katha Sikka', 'Vice President + Co-director of the South Asian Mentorship Program', 2020, 'Government + English', 'New Brown America must dispel the notion that there is one type of Desi—or that certain characteristics & choices are more Desi than others. We are not a model minority; we cannot erase the narratives of (undocumented) immigrants, Muslims, members of the LGBTQ+ community, and those with disabilities and mental health issues. We may be doctors and engineers—but we are also activists and artists. We can flash our jhumkas and kurtas—but also our tattoos and piercings. Desis can be radical; Desis can be cultural—but we are all equal. We will strive to dismantle intra-community attitudes—of sexism, classism, colorism, and anti-blackness—that hegemonically favor some Desis over others. Contesting the black-white binary, we will demand that dialogue about such intersectional truths occupy deserved space in social justice coalitions and mainstream media. Desi Americans in New Brown America must also remember their motherlands—both the rich culture as well as the often problematic, intolerant politics. South Asia spans many nations, not just India and Pakistan but also Bangladesh and Sri Lanka. We must subvert any tendency to render our Desi-American identity monolithic and to consider some nations as superior to others.
', 'Events Coordinator of Marginalia: the Cornell Undergraduate Poetry Review, Treasurer of Asha Cornell, Tutor at Cornell’s Writing Center');
INSERT INTO members (file_name, ext, name, position, year, major, hometown, description, involvement) VALUES ('aliza', 'jpg', 'Aliza Adhami', 'Senior Advisor', 2019, 'Human Biology, Health and Society', 'Fort Wayne, Indiana', 'I envision a future where the South Asian community can come together across religious, cultural, and national divides. I hope to see greater representation for marginalized groups within our community and for all of the diverse identities that come under the term “South Asian.” I hope we can cultivate a space that fosters community regardless of what being ‘brown’ means to you!', 'HE Dean’s Advisory Council, former President of the Pakistani Students Association, cognitive science research');
INSERT INTO members (file_name, ext, name, position, year, major, description, involvement) VALUES ('rachel', 'jpg', 'Rachel George', 'Social Media Chair', 2021, 'Biomedical Engineering', 'My New Brown America will be a place where all Desis can thrive without having to apologize for or justify their success. My New Brown America will be a place where all Desi-Americans, no matter where they hail from, are not clumped into a singular category-- we will be able to be heard and seen as individuals with our own traditions and roots. My New Brown America will promote the dignity and respect that all people deserve.', 'SWE, BMES, Cornell iGEM');
INSERT INTO members (file_name, ext, name, position, year, major, description, involvement) VALUES ('hansika', 'jpg', 'Hansika Iyer', 'Mental Health Co-coordinator', 2019, 'Fiber Science and Apparel Design', 'We can choose our own career paths and majors without feeling that we are “disappointments” or that our choices are disrespecting the hard work of our parents, and without justifying our passions. I’m a fashion major and it’s an unconventional career path, but I love it!', 'President of Cornell Fashion Industry Network, Cornell Big Red Raas, Cornell Sustainability Consultants, Cornell Fashion Collective Designer, Hecho por Nosotros events coordinator');
INSERT INTO members (file_name, ext, name, position, year, major, minor, hometown, description, involvement) VALUES ('smita', 'jpg', 'Smita Bhoopatiraju','Mental Health Co-coordinator', 2021, 'Psychology', 'Inequality Studies', 'Plymouth Minnesota', 'I envision a New Brown America in which Desi Americans demand the dignity and respect they deserve. Our voices would be heard and supported in discussions surrounding racism and inequality. Desi presence would also be more common in mainstream culture, and in a way that allows us to take control of our own narratives and embrace our intersectional identities. Brown people would no longer bear the burdens of discrimination in silence, but rather would be on the frontlines of the fight, demanding that anything less than complete equality is unacceptable', 'Hindu Student Council secretary, Clara Dickson Hall resident advisor, National Residence Hall Honorary, Alpha Epsilon Delta, Global Medical and Dental Brigades, Cornell Association of Medicine and Philanthropy, former program assistant for the Multicultural Living Learning Unit');


CREATE TABLE 'chai' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'event_name' TEXT NOT NULL,
  'img_name' TEXT NOT NULL,
  'img_ext' TEXT NOT NULL,
  'description' TEXT
);

INSERT INTO chai (event_name, img_name, img_ext, description) VALUES ('Chai & Chat: South Asian Refugee Crises Past and Present', 'cc4-19', 'jpg', 'Political confusion, gridlocked regional interests, and groundless stereotypes are taking our attention away from the refugee crisis. Join us and Cornell Welcomes Refugees during its Week of Action for Refugees in raising awareness and mobilizing the community in regards to this global crisis specific to South Asia. We will be grappling with the complexities arising from the Rohingya genocide, the Sri Lankan Civil War, and the India/Pakistan partition. As always, free samosas and lassi from New Delhi Diamonds!');
INSERT INTO chai (event_name, img_name, img_ext, description) VALUES ('Chai & Chat x FGSU: The Narratives of FGLI South Asian Students', 'cc3-19', 'jpg', 'Come join FGSU and SAC at an interactive teach-in as part of our Chai and Chat series on 03/19! We’ll be discussing the different aspects of being first generation/low income and exploring the intersection between our two communities. We will also have THREE incredible speakers, including Shakima Clency (Associate Dean and Director of First-Generation/Low-Income Student Support), providing their insights and knowledge and answering questions or concerns from the community in a Q&A panel. FREE lassi, samosas, and chutney from New Delhi Diamonds Indian Restaurant in WSH 411 as always!');
INSERT INTO chai (event_name, img_name, img_ext, description) VALUES ('Chai & Chat: Interracial Dating', 'cc3-12', 'jpg', 'Join our community members in sharing our experiences with dating people who are from outside the Desi diaspora (or even from within the diaspora, but across ethnic, "motherland" state, national, caste, and/or religious differences)! Film & TV suggestions: Meet The Patels, The Big Sick, The Mindy Project, Ek Tha Tiger, Ishaqzaade and Veer-Zaara. Free hot chai, samosas, and chutneys from New Delhi Diamonds Indian Restaurant in WSH 411 as always! Speaking of relationships, we will be revealing the 2019 Interfaith Mock Shaadi bride & groom pair at the end of this Chai & Chat!');
INSERT INTO chai (event_name, img_name, img_ext, description) VALUES ('Chai & Chat: Queering Desi', 'cc2-12', 'jpg', 'Come for the chai, stay for the chat! Queering Desi strives to center  LGBTQIA+ South Asians & to empower them with a space to share their often-erased narratives. SAC is so excited to be collaborating with Mosaic, Cornell’s social support group for QTPOC and their allies, for this intersectional Chai & Chat. There will be free samosas and chai! We know you can"t wait! So, in the meantime, listen to the Queering Desi (https://audioboom.com/channels/4947270)! Priya Arora, one of Brown Girl Magazine’s editors, hosts this weekly podcast.');
INSERT INTO chai (event_name, img_name, img_ext, description) VALUES ('Chai & Chat x Breaking Bread: Faith and the Desi Diaspora', 'cc2-5', 'jpg', 'Come for the chai and samosas, stay for the chat! This Interfaith Breaking Bread seeks to foster a dialogue about grappling with the consequences of our/our parents’ motherlands’ partitions and religious differences in the Cornell South Asian American diasporic community. Please fill out this form (https://docs.google.com/forms/d/e/1FAIpQLSdKiDYHfDwDyYWKuuSR7W-R9QbSkg9nRgBDLsrR8MVY_50bHA/viewform) so we can better cater the conversation to the various identities present at the chat!');


-- Other Events table

CREATE TABLE 'otherevents' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'title' TEXT NOT NULL,
  'link' TEXT,
  'file_name' TEXT NOT NULL,
  'ext' TEXT NOT NULL,
  'source' TEXT,
  'sourcelink' TEXT
 );

INSERT INTO otherevents (title, link, file_name, ext, source, sourcelink) VALUES ('Alok Menon', 'https://www.facebook.com/events/261307161412841/', 'Alok', 'jpg', 'South Asian Council', 'https://www.facebook.com/SouthAsianCouncilCornell/');
INSERT INTO otherevents (title, link, file_name, ext, source, sourcelink) VALUES ('Palestine 101', 'https://www.facebook.com/events/1431965043603716/', 'palestine', 'jpg', 'Cornell Students for Justice in Palestine', 'https://www.facebook.com/CornellS4JP/?eid=ARB1XhoNSj9aXXAyMvtmCPZNHF6w3W2paRbg1KtGJxisTiPwAM1jbEg8s4F6mGrYS325RdVAYz_5mz0q');
INSERT INTO otherevents (title, link, file_name, ext, source, sourcelink) VALUES ('Panel Discussion on Voting Rights in the U.S.', 'https://www.facebook.com/events/2120064224697171/', 'panel', 'jpg', 'Pi Sigma Alpha - Cornell University', 'https://www.facebook.com/CornellPiSigmaAlpha/?eid=ARDSxmEv9jPD2_uTwlWnZFu08LJCMesVzaDLvXF79FGgmr0kPMW6zv_f0f1DzgCcaU4RHUINKB_TJMeT');
INSERT INTO otherevents (title, link, file_name, ext, source, sourcelink) VALUES ('Radiant Voices: Citizenship', 'https://www.facebook.com/events/269521010597673/', 'voices', 'jpg', 'Marginalia', 'https://www.facebook.com/marginaliareview/');
INSERT INTO otherevents (title, link, file_name, ext, source, sourcelink) VALUES ('Dining with Diverse Minds: Model Minority Myth & Mental Health', 'https://www.facebook.com/events/524532204741529/', 'dining', 'jpg', 'ALANA Intercultural Board', 'https://www.facebook.com/ALANAInterculturalBoard/?eid=ARDLtQFjjMKxb2NF740_u9iQKV4q4zww2lOod7WFFuo-JrCwgZqhx8qY__lg1MP5uEV-gkBSg-tbFLdV');


-- Member Organization table

CREATE TABLE 'memberOrgs' (
   'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
   'name' TEXT NOT NULL,
   'desc' TEXT
 );

 CREATE TABLE `orgTags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`tag_name` TEXT NOT NULL UNIQUE
);

CREATE TABLE `memberOrg_orgTags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`org_id` INTEGER NOT NULL,
	`tag_id` INTEGER NOT NULL
);

 INSERT INTO memberOrgs (id, name, desc) VALUES (1, 'Anjali', 'Founded in 2011, Anjali aims to spread the awareness of Bharatanatyam and other classical dance styles by performing and competing on and off campus.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (2, 'Asha Cornell', 'Asha for Education is a non-profit organization dedicated to the support of basic education in India. Asha, which means hope in many Indian dialects, was founded at the University of California, Berkeley in 1991 and has since grown to over 50 chapters scattered throughout the United States, Europe, East Asia and India. Each of these chapters raises funds to support various education-related projects in India.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (3, 'Bengali Students'' Association', 'The Bengali Student Association looks to provide support & community to students who are interested in Bengali Culture or come from a Bengali background.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (4, 'Big Red Raas', 'Founded in 2005, Cornell Big Red Raas is a competitive Raas/Garba dance team. Raas/Garba is a traditional dance originating in Gujarat, India, but BRR revamps it with modern moves for a truly energizing and crowd-pleasing performance.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (5, 'Cornell Bhangra', 'Founded in 1997, Cornell Bhangra''s goal is to promote awareness of Punjabi dance and culture in the community and across the nation. Bhangra is a folk dance originating in the state of Punjab in Northern India and Pakistan that celebrates the arrival of spring and everyday culture/life in Punjab.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (6, 'Cornell India Association', 'The Cornell India Association is a graduate student group that brings together people from the Cornell University campus as well as surrounding communities interested in Indian language and culture.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (7, 'Cornell Pakistan Society', 'The Cornell Pakistan Society is the student organization for graduate and Professional sudents at Cornell from Pakistan. The Pakistan Society provides a platform where current issues of importance regarding Pakistan and South Asia can be discussed, as well as promote the understanding of Pakistani culture at Cornell through organizing cultural events.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (8, 'Cricket Club', 'Cornell Cricket Club seeks to promote the game of cricket amongst the Cornell and Ithaca community by arranging matches and practice sessions and introducing the game to new players. It also seeks to compete against other universities and in national level tournaments to promote the game to a broader US audience.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (9, 'Hindu Student Council', 'The Hindu Student Council at Cornell University aims to bring the traditions and culture of Hinduism to Ithaca! We host weekly bhajans and discussions, as well as pujas for larger Hindu holidays. Our most popular event is Holi, the festival of colors. Our Diwali Dhamaka in Klarman this year was also a smashing success and we hope to see the event grow in the future. ');
 INSERT INTO memberOrgs (id, name, desc) VALUES (10, 'Nazaqat', 'We aim to convey the elegance and beauty in Kathak, a classical Indian dance form, through creative fusion choreographies on semi-classical or modern music. We hope to make choreographies that preserve grace and story-telling in the dance form yet creatively combine it with contemporary indian music and dance.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (11, 'Nepal Association', 'The Nepal Association''s members include undergraduate and graduate students, as well as professors and others, who have conducted research or are interested in the Himalayan region. It aims to promote Nepali culture through social, cultural, and academic means. Activities in the past have included informal gatherings, discussions, films, folk dance, and the annual Dashain festival.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (12, 'Pakistani Students'' Association', 'The Pakistani Students Association (PSA) is an organization and community for all Cornell members of Pakistani background and those with interests in Pakistani culture and identity. PSA strives to educate the Cornell community and advocate for Pakistani issues, and celebrate Pakistani culture through various events throughout the year.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (13, 'Sikh Student Association', 'Sat Sri Akal! Welcome to Cornell Sikh Students Association, a voice for Sikh students on campus and a platform for Sikh awareness and identity.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (14, 'Sitara','Sitara is Cornell’s Premier Bollywood fusion dance team infusing Indian classical dance with hip hop, Bollywood, and modern dance.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (15, 'Society for India', 'The Society for India strives to promote Indian culture and spread South Asian awareness at Cornell through its various annual events.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (16, 'SPICMACAY', 'SPICMACAY is the Society for the Promotion of Indian Classical Music And Culture Amongst Youth. Started in 1977, SPICMACAY now has chapters all over the world. The overall mission of SPICMACAY and its international activities can be found at http://spicmacay.com/ .');
 INSERT INTO memberOrgs (id, name, desc) VALUES (17, 'South Asian Business Club', 'The South Asian Business Club facilitates stronger ties between the Johnson community and the global South Asian business community, including regional government, non-profit organizations, academia and media, while facilitating cultural understanding within a business-specific context.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (18, 'South Asian Law Students Association', 'The South Asian Law Students Association promotes education and leadership among South Asian law students and expands students’ understanding and appreciation of South Asian political, legal and social issues. SALSA hopes to provide a space for law students interested in the South Asian experience to gather, create support networks, and form a community.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (19, 'Sri Lankan Students'' Association', 'SLSA serves two purposes. First, it acts as a community for Sri Lankan diaspora at Cornell. Second, it is the vehicle through which individuals of Sri Lankan heritage share their unique culture with Cornell at large. The sense of community is fostered through informal gatherings and dinners among members. SLSA members exhibit their culture through traditional tea ceremonies and participation in campus-wide events like Taste of Culture.');
 INSERT INTO memberOrgs (id, name, desc) VALUES (20, 'Tarana Hindi A Cappella', 'Tarana is Cornell University’s first and only south asian, co-ed a cappella group. Founded in 2010, they perform a variety of genres to bring together the musical traditions of the East and the West. Solid music, fun performances and good looks have fast made the group a fixture at the various shows around Cornell and other cities in the Northeast. In addition, they have an annual showcase which attracts hundreds of fellow students and fans. Tarana hold auditions every semester and looks forward to seeing you at their next performance!');

INSERT INTO `orgTags` (id, tag_name) VALUES (1, 'performance');
INSERT INTO `orgTags` (id, tag_name) VALUES (2, 'cultural');
INSERT INTO `orgTags` (id, tag_name) VALUES (3, 'service');
INSERT INTO `orgTags` (id, tag_name) VALUES (4, 'professional');
INSERT INTO `orgTags` (id, tag_name) VALUES (5, 'sport');

INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (1, 1, 1);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (2, 2, 3);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (3, 3, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (4, 4, 1);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (5, 5, 1);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (6, 6, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (7, 7, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (8, 8, 5);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (9, 9, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (10, 10, 1);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (11, 11, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (12, 12, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (13, 13, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (14, 14, 1);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (15, 15, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (16, 16, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (17, 17, 4);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (18, 18, 4);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (19, 19, 2);
INSERT INTO `memberOrg_orgTags` (id, org_id, tag_id) VALUES (20, 20, 1);


COMMIT;

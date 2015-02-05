#Category Title Data
INSERT INTO `categories` (`title`) VALUES ("Science");
INSERT INTO `categories` (`title`) VALUES ("Math");
INSERT INTO `categories` (`title`) VALUES ("Construction");
INSERT INTO `categories` (`title`) VALUES ("Programming");
INSERT INTO `categories` (`title`) VALUES ("Cooking");
INSERT INTO `categories` (`title`) VALUES ("Multi Media");

#Subcategory Title and Categoryid Data
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Chemistry",1);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Biology",1);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Physics",1);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Earth",1);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Astronomy",1);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Atmospheric",1);

INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Geometry",2);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Calculus",2);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Algebra",2);

INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Home",3);

INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Web",4);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Mobile",4);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Desktop",4);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Game",4);

INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Desserts",5);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Italian",5);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("French",5);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Japanese",5);

INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Videos",6);
INSERT INTO `subcategories` (`title`,`categoryid`) VALUES ("Audio",6);

#Users Email, Firstname, Lastname and Password
INSERT INTO `users` (`email`,`firstname`, `lastname`, `password`) VALUES ("atest@test.com", "Chef", "Ramsey", "GetOut");
INSERT INTO `users` (`email`,`firstname`, `lastname`, `password`) VALUES ("test@test.com", "Bob", "Barker", "PriceIsRight");
INSERT INTO `users` (`email`,`firstname`, `lastname`, `password`) VALUES ("testing@test.com", "Chris", "Bale", "IAmBatman");
INSERT INTO `users` (`email`,`firstname`, `lastname`, `password`) VALUES ("moretests@test.com", "Bill", "Nye", "TheScienceGuy");
INSERT INTO `users` (`email`,`firstname`, `lastname`, `password`, `admin`) VALUES ("evenmoretests@test.com", "Admin", "Admin", "Admin", 'y');

#Template Ownerid, Subcategoryid, Title, Description and Version
INSERT INTO `templates` (`ownerid`,`subcategoryid`, `title`, `description`, `version`) VALUES (4, 19, "Science Show", "A show that teaches and entertains people about science.", '1');
INSERT INTO `templates` (`ownerid`,`subcategoryid`, `title`, `description`, `version`, `sourcetemplateid`) VALUES (5, 19, "A Teen Science Show", "A show that teaches and entertains teenagers about science.", '2', 1);
INSERT INTO `templates` (`ownerid`,`subcategoryid`, `title`, `description`, `version`, `visibility`) VALUES (1, 15, "Bake a Cake", "I will teach you to make gloop into cake.", '1', 'private');
INSERT INTO `templates` (`ownerid`,`subcategoryid`, `title`, `description`, `version`, `visibility`) VALUES (2, 9, "Add", "I will teach you to add 2 numbers.", '1', 'public');

#Task Title, Duration and Templateid
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `templateid`) VALUES (1, "Filming", "5 h", 1); 
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`) VALUES (2, "Setting up", "2 h", 1, 1);
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`, `predecessorids`) VALUES (3, "Shooting", "3 h", 1, 1, "2");
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`, `predecessorids`) VALUES (4, "Filming complete", "0", 1, 1, "3");

INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `templateid`) VALUES (1, "Filming", "6 d", 2);
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`) VALUES (2, "Planning Shots", "2 d", 1, 2); 
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`) VALUES (3, "Scouting area", "1 d", 2, 2);
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`) VALUES (4, "Marking positions", "1 d", 2, 2);
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`, `predecessorids`) VALUES (5, "Planning complete", "0", 2, 2, "3,4");
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`, `predecessorids`) VALUES (6, "Setting up", "2 d", 1, 2, "5");
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`, `predecessorids`) VALUES (7, "Shooting", "3 d", 1, 2, "6");
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `summarytaskid`, `templateid`, `predecessorids`) VALUES (8, "Filming complete", "0", 1, 2, "7");

INSERT INTO `tasks` ( `taskid`, `title`, `note`, `duration`, `templateid`) VALUES (1, "Mix", "Put gloop into a mixing machine", "1 h", 3); 
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `templateid`, `predecessorids`) VALUES (2, "Bake", "3 h", 3, "1");
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `templateid`, `predecessorids`) VALUES (3, "Eat", "1 h", 3, "2");
INSERT INTO `tasks` ( `taskid`, `title`, `duration`, `templateid`, `predecessorids`) VALUES (4, "Get Out", "0", 3, "3");

INSERT INTO `tasks` ( `taskid`, `title`, `note`, `duration`, `templateid`) VALUES (1, "Add", "Take first number and merge with second", "1 h", 4); 
INSERT INTO `tasks` ( `taskid`, `title`, `note`, `duration`, `templateid`, `predecessorids`) VALUES (2, "The price is right", "Don't forget to spay and neuter your pets", "0", 4, "1");
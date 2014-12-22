/* DROP TABLE glu_users; */
CREATE TABLE glu_users (
    ID CHAR(40) PRIMARY KEY,
    FirstName CHAR(20) NOT NULL,
    LastName CHAR(20) NOT NULL,
    Email CHAR(40) NOT NULL,
    Phone CHAR(20),
    PackageName CHAR(40) NOT NULL,
    Organization CHAR(40) NOT NULL,
    ResearchArea CHAR(80) NOT NULL,
    WhenApplied DATETIME NOT NULL,
    WhyApplied CHAR(200)
);

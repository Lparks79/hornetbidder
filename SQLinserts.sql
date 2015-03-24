INSERT INTO Users (Username, Fname, Lname, Password, Street, City, Zip, State, Email) 
VALUES ('Bob', 'Bobby', 'Edwards', md5('password'), '555 Peachtree lane', 'Atlanta', 30001, 'GA', 'fakeemail@fake.com');
SELECT * FROM Users;

INSERT INTO Item (Seller, Title, Description, Endtime, Status, Price)
VALUES (2, 'Red Dead Revolver', 'Used video game', now() + '72 hours', 'active', 10);
SELECT * FROM Item;

INSERT INTO ItemCategories VALUES (1,2);
SELECT * FROM ItemCategories;

INSERT INTO Categories (Name, ParentCategory) VALUES ('Games',1);
SELECT * FROM Categories;

INSERT INTO Bids (AuctionNum, Bidder, Amount, bidTime) VALUES (1,2,45.50,now());
SELECT * FROM Bids;
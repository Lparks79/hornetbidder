Larry Parks
CS3153

--Created and checked
CREATE TABLE Users (
	Id serial primary key,
	Username varchar(20) UNIQUE,
	Fname varchar(20) NOT NULL,
	Lname varchar(20) NOT NULL,
	Password TEXT NOT NULL,
	Street varchar(30),
	City varchar(20),
	Zip INTEGER,
	State varchar(20),
	Email varchar(30)
);


--Created and checked
CREATE TABLE Item (
	Id SERIAL PRIMARY KEY,
	Seller INTEGER REFERENCES Users(Id),
	Title varchar(30) NOT NULL,
	Description TEXT,
	EndTime TIMESTAMP,
	Status varchar(10),
	Price NUMERIC(10,2)
);


--Created and tested
CREATE TABLE ItemCategories (
	AuctionNum INTEGER REFERENCES Item(Id),
	Category INTEGER REFERENCES Categories(Id)
	--CONSTRAINT RI-PK PRIMARY KEY
	--		(AuctionNum, Category)
);


--Created and Tested
CREATE TABLE Categories (
	Id SERIAL PRIMARY KEY,
	Name VARCHAR(20),
	ParentCategory INTEGER REFERENCES Categories(Id)
);


--Created and Tested
CREATE TABLE Bids (
	Id SERIAL PRIMARY KEY,
	AuctionNum INTEGER REFERENCES Item(Id),
	Bidder INTEGER REFERENCES Users(Id),
	Amount NUMERIC(10,2),
	bidTime TIMESTAMP
);

CREATE TABLE Purchases (
	Id SERIAL PRIMARY KEY,
	Buyer INTEGER REFERENCES Users(Id),
	AuctionNum INTEGER REFERENCES Item(Id),
	BidNum INTEGER REFERENCES Bids(Id),
	CC TEXT,
	Status VARCHAR(20)
);
	



CREATE VIEW listings_submissions AS

SELECT * FROM list_sc17_io500
UNION ALL

SELECT * FROM list_isc18_io500
UNION ALL

SELECT * FROM list_isc19_10node
UNION ALL
SELECT * FROM list_isc19_full
UNION ALL
SELECT * FROM list_isc19_io500
UNION ALL

SELECT * FROM list_isc20_10node
UNION ALL
SELECT * FROM list_isc20_full
UNION ALL
SELECT * FROM list_isc20_historical
UNION ALL
SELECT * FROM list_isc20_io500
UNION ALL

SELECT * FROM list_sc18_10node
UNION ALL
SELECT * FROM list_sc18_io500
UNION ALL
SELECT * FROM list_sc18_star_10node
UNION ALL
SELECT * FROM list_sc18_star_io500
UNION ALL

SELECT * FROM list_sc19_10node
UNION ALL
SELECT * FROM list_sc19_full
UNION ALL
SELECT * FROM list_sc19_historical
UNION ALL
SELECT * FROM list_sc19_io500
UNION ALL

SELECT * FROM list_sc20_10node
UNION ALL
SELECT * FROM list_sc20_full
UNION ALL
SELECT * FROM list_sc20_historical
UNION ALL
SELECT * FROM list_sc20_io500;
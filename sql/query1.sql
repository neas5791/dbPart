SELECT CONCAT(tbPart.prefix, tbPart.id) AS 'PID', tbPart.descr AS 'DESCRIPTION', IFNULL(tbDrawing.drawing_number,'') AS 'PART NUMBER'  FROM tbPart
LEFT OUTER JOIN tbDrawing ON tbPart.id = tbDrawing.partid
UNION
SELECT CONCAT(tbPart.prefix, tbPart.id) AS 'PID', tbPart.descr AS 'DESCRIPTION', tbSupplierPart.sup_part_number AS 'PART NUMBER' FROM tbPart
LEFT OUTER JOIN tbSupplierPart ON tbPart.id = tbSupplierPart.partid
ORDER BY PID;
'
+---------+----------------------------------+-------------------+
| PID     | DESCRIPTION                      | PART NUMBER       |
+---------+----------------------------------+-------------------+
| P300000 | RELAY CHANGE OVER  24V 30A 5 PIN |                   |
| P300000 | RELAY CHANGE OVER  24V 30A 5 PIN | 0 332 209 203     |
| P300001 | INTERPUMP WS202                  |                   |
| P300001 | INTERPUMP WS202                  | WS202             |
| P300002 | TROJAN CLEVIS PIN (3/4")         | SEAOARD 19.05 PIN |
| P300002 | TROJAN CLEVIS PIN (3/4")         | HARDENED PIN 3/4  |
| P300002 | TROJAN CLEVIS PIN (3/4")         | 35T-301           |
| P300003 | TRUCK SIDE DECK SHEET            | T0055             |
| P300003 | TRUCK SIDE DECK SHEET            | DECK SIDE SHEET   |
| P300004 | REVERSE BEEPER 12/24V 107db      | ACX5136           |
| P300004 | REVERSE BEEPER 12/24V 107db      |                   |
+---------+----------------------------------+-------------------+'

SELECT CONCAT(tbPart.prefix, tbPart.id) AS 'PID', tbPart.descr AS 'DESCRIPTION', IFNULL(tbDrawing.drawing_number,'') AS 'DWG NUMBER',tbSupplierPart.sup_part_number AS 'PART NUMBER' FROM tbPart
LEFT OUTER JOIN tbDrawing ON tbPart.id = tbDrawing.partid
LEFT OUTER JOIN tbSupplierPart ON tbPart.id = tbSupplierPart.partid
ORDER BY PID;
'
+---------+----------------------------------+------------+-------------------+
| PID     | DESCRIPTION                      | DWG NUMBER | PART NUMBER       |
+---------+----------------------------------+------------+-------------------+
| P300000 | RELAY CHANGE OVER  24V 30A 5 PIN |            | 0 332 209 203     |
| P300001 | INTERPUMP WS202                  |            | WS202             |
| P300002 | TROJAN CLEVIS PIN (3/4")         | 35T-301    | HARDENED PIN 3/4  |
| P300002 | TROJAN CLEVIS PIN (3/4")         | 35T-301    | 35T-301           |
| P300002 | TROJAN CLEVIS PIN (3/4")         | 35T-301    | SEAOARD 19.05 PIN |
| P300003 | TRUCK SIDE DECK SHEET            | T0055      | DECK SIDE SHEET   |
| P300004 | REVERSE BEEPER 12/24V 107db      |            | ACX5136           |
+---------+----------------------------------+------------+-------------------+'

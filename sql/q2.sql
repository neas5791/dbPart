SELECT tbPart.id AS "PID",  tbPart.descr AS "DESCRIPTION", IFNULL(tbDrawing.drawing_number,"") AS "DWG_NUMBER" FROM tbPart
LEFT JOIN tbDrawing ON tbPart.id = tbDrawing.partid
ORDER BY PID
select 
    LogicalConnectiveSymbol_idLogicalConnectiveSymbol as idLogicalConnectiveSymbol,
    LogicalConnectivePhrase_idLogicalConnectivePhrase as idLogicalConnectivePhrase,
    logicalConnectivePhrase
from
    LogicalConnectivePhrase_has_LogicalConnectiveSymbol h
        inner join
    LogicalConnectivePhrase p
where
    h.LogicalConnectivePhrase_idLogicalConnectivePhrase = p.idLogicalConnectivePhrase
        AND h.LogicalConnectiveSymbol_idLogicalConnectiveSymbol = 2;

select 
    LogicalConnectiveSymbol_idLogicalConnectiveSymbol as idLogicalConnectiveSymbol,
    LogicalConnectivePhrase_idLogicalConnectivePhrase as idLogicalConnectivePhrase,
    logicalConnectivePhrase
from
    LogicalConnectivePhrase_has_LogicalConnectiveSymbol h
        inner join
    LogicalConnectivePhrase p
where
    h.LogicalConnectivePhrase_idLogicalConnectivePhrase = p.idLogicalConnectivePhrase
;

SELECT 
    *
FROM
    Igitur.LogicalConnectivePhrase_has_LogicalConnectiveSymbol phs inner join Igitur.LogicalConnectiveSymbol s on ph

    Igitur.LogicalConnectivePhrase_has_LogicalConnectiveSymbol.LogicalConnectiveSymbol_idLogicalConnectiveSymbol = 2;
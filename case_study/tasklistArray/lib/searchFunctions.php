<?php

/**
 * usiamo una funzione di ordine superiore è una  funzione
 * che restituisce una funzione
 * è una funzione che restituisce una funzione
 * la funzione ricerca, return, sarebbe questa.
 * 
 * Programmazione Funzionale - dichiarativo
 * */


function searchText($searchText)
{
    // la variabile $searchText è una variabile locale
    // per la funzione esterna

    //per fare in modo che $searchText sia visibile (nel senso di ambito)
    // o che abbia l'ambito valido all'interno
    // della funzione anonima devo usare 'use'

    return function ($taskItem) use ($searchText) {
  
        $result = strpos($taskItem['taskName'], $searchText) !== false;
        return $result;
 
    };
}
###Laborationsrapport för 1DDv449_L02 av jh222vp

#Säkerhetsbrister

##Inloggningsidan

1. Man kan logga in med vad som helst
2. Finns ingen begränsning mot att stoppa in önskade tecken så som
taggar, specialtecken och tomma strängar.
3. Verkar inte finnas någon kontroll om man är autentiserad så man kan direkt hoppa in mot mess.php
4. Sårbarhet mot SQL-injections finns då värdet som skrivs in skjuts in direkt i SQL-queryn

##Redogör för hur säkerhetshålet kan utnyttjas
1. Man kan komma förbi inloggningspärren med att skriva vad som helst
2. Man kan med SQL-injections komma förbi inloggningspärren (t.ex ' or '1'='1'--)
3. Man kan får tillträde till mess.php endast genom att skriva in sökvägen dit.

##Vad för skada kan säkerhetsbristen göra?
SQL-injections kan vara förödande, en elak hackare kan dumpa alla användare och lösenord
och sedan skriva kommentarer från andra konton. Han kan också välja att dropa hela datorbasen
så att ingen längre kan logga in.

##Meddelandesidan

1. Namnfält och meddelandefält går att skriva in taggar, whitespaces och specialtecken i.
2. SQL Injections går att göra.
3. XSS är möjligt att göra, dessa blir dessutom persistenta.
4. Utseendet kan förstöras då HTML och CSS går utmärkt att ladda in.
5. Lösenord i klartext i databasen.
6. CSRF möjligt.
7. "Fejkad" utloggning.

##Redogör för hur säkerhetshålet kan utnyttjas

1. Dumpa eller dropa datorbasen via SQL-injection.
2. Samla andra användares cookies med hjälp av XSS, skicka användare till andra sidor med XSS osv.
3. Få användare att tro att de är på en sida som de inte är på då man kan ändra utseendet.
4. Länka till farliga .exe filer med XSS och hävda att de kommer ifrån labbymessage.
5. Om en elak person skulle få tag i datorbasen så ser man användarnas lösenord i klartext.
   Det här kan sen sprida vidare till att en användare som använt samma lösenord på andra hemsidor är utsatt även där
6. En användare av vår sida kan bli lurad att klicka på en elak länk som gör ett request som i sin tur leder till en POST av ett meddelande i det requestet.
7. Ingen riktig utloggning finns utan endast en "Redirect" som leder tillbaka till INDEX-sidan. Ingen session-dödare eller liknande finns.


##Vad för skada kan säkerhetsbristen göra?
Om en elak kodare ser till att t.ex länka programvara från en elak sida genom labbymessage så tror
användarna som kommer in på sidan att det är en programvara som är säker från labbymessage.
Tömma hela datorbasen på användare och lösenord så ingen kan posta från sitt konto med hjälp av SQL injectioner
eller dumpa ut alla användare och lösenord.
Fiska efter andra användares cookies med hjälp av XSS.
Länka andra användare vidare till en farlig hemsida som innehåller virus med hjälp av redirect.
Möjligt att förstöra utseendet och få användare att tro att de kanske är på en annan sida än de egentligen är.


##Hur du har åtgärdat säkerhetshålet i applikationskoden?
I check.php så var isUser tvungen till att returnera true eller false så i sec.php och isUser functionen returneras false om det inte finns något resultat annars true.
Där man kunde stoppa in taggar, whitespaces och liknande satte jag "trim" samt "stripe_tags" för att få bort dessa farligheter.(XSS)
SQL-förfrågningarna är nu parametriserade så dessa inte skrivs in direkt i SQL utan gör PDO och en array som executar.
CSRF åtgärdad med Synchronizer Token Pattern.
Krypterat lösenorden i datorbasen.
Det fanns ingen riktigt utloggning utan endast en "redirect". Ser nu till att döda sessionerna när en användare vill logga ut.

#Del 2 - Optimering

##Namn på åtgärd Du gjort för att försöka förbättra prestandan

###Styling i HTML flyttad till egen css
Flyttade ut css som låg i bland annat index.php och mess.php till en egen fil.
Detta för att filen har möjlighet att bl.a cachas vilket kan optimera laddningstiderna vid publicering i molnet.
Det går även långsammare att ladda sidan om man har det på detta sätt.

###Script-taggar placerade längst ner i "body"

Genom att placera scrip-taggarna längst ner på sidan så laddas sidan in först och man behöver inte vänta på något grafikt
medan de andra scripten laddas in. Detta gör att användaren kan uppleva det som snabbare då "något händer" även om det
är samma filer och tid totalt sett.

###Minifiering med JQUERY och bootstrap
Här har jag valt att länka till minifierade filerna av jquery och bootstrap.
Vid minifiering tas allt onödigt bort vilket leder till mindre filer och det går då snabbare att ladda in och läsa filerna.


###Observation (laddningstid, storlekar av resurser, anrop m.m.) innan åtgård (utan webläsar-cache - gärna ett medeltal av ett antal testningar)
Index.php - Size: 1.1kb - Time/Latency 38ms/37ms.
Bootstrap.css - Size 124kb - Time/Latency 195ms/35ms.
Bootstrap.js - Size 66.0kb - Time/Latency 164ms/42ms.

###Messy
Här är orginalkoden långsammare, verkar som om det försöks läsas in ett js-script som inte existerar och detta tar tid.

###Observation (laddningstid, storlekar av resurser, anrop m.m.) efter åtgärd (utan webläsar-cache - gärna ett medeltal av ett antal testningar)
Index.php - Size: 1.1kb - Time/Latency 30ms/31ms.
bootstrap.min.css - maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css - Size: 23,8KB
LoginStyle.css - Size: 1.2KB.

###Messy
Här är den modifierade koden snabbare, sparar ca 200ms tack vare optimeringen. Så från ca 1sek till 800ms mellan orignal
koden och den modifierade.

##Long polling
Longpollingen är gjord som så att jag har en loop i get.php som varar i 20 sekunder.
Vad som sker i loopen är att alla meddelandena från databasen hämtas ut och sedan så sparar vi ned tiden från
det nyaste meddelandet i en variabel. Variabeln med tidstämplen matchar vi sedan med tiden från det senaste meddelandet
från klienten. Om fallet är så att tiden är den samma i dessa variablerna finns det inga nya medddelanden.
Skulle dessa dock skilja sig från varandra så finns det nya meddelanden att hämta.

##Fördelar med Long-Polling

Enkel simulering av Server-Push
Long-Polling funkar väl antar jag att ha som lösning om det t.ex inte finns stöd för Web Sockets.

##Nackdelar med Long-Polling
Servern måste hålla "connectionen" öppen.

Klienten måste fråga efter data.

Kan bli stor belastning på webservern om det är många klienter som samtidigt frågar efter data.

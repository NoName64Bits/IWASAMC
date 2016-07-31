I WAS A MC (Integrated Web-based Automation System And Media Center) reprezinta un sistem complet alcatuit din mai multe componente hardware si software care are ca scop primar integrarea dispozitivelor de uz casnic (iluminare, electonice, electrocasnice, etc) in "lumea smart" cu ajutorul unui asistent virtual ce asculta comenzi vocale din mai multe surse. Obiectivele secundare sunt monitorizarea parametrilor de stare ambientali din interiorul locuintei si a securitatii acesteia cat si oferirea unei metode de divertisment complexe utilizatorului: un singur set de difuzoare, mai multe surse de audio si mai multe moduri de control: aplicatie nativa (Windows, Android, iOS), web, control vocal (inca neimplementat).

Hardware
Hardware-ul este alcatuit din doua parti principale:
- centrul de control (prescurtat CC, dispozitivul conectat la difuzor), in cazul acesta, un RPi B+
- arhitectura dispozitivelor de control si monitorizare (dispozitivele care asculta pentru query-uri care provin de la CC): poate fi alcatuita din mai multe dispozitive care se clasifica dupa rolul pe care il indeplinesc in: master (dispozitiv conectat la retea) si slave (dispozitiv conectat la un master) si dupa relatia pe care o au cu ecosistemul in: WID (WAN Input Device, primeste date direct de la endpoint, explicat mai jos, memoreaza "clinet secret"-ul), WOD (WAN Output Device, trimite date direct catre endpoint, explicat mai jos, memoreaza "client secret-ul"), LID (LAN Input Device, primeste date de la endpoint prin intermediul CC-ului, explicat mai jos, nu are contact direct cu "client secret"-ul acesta fiind manageriat de CC) si LOD (LAN Output Device, trimite date catre endpoint prin intermediul CC-ului, explicat mai jos, nu are contact direct cu "client secret"-ul acesta fiind manageriat de CC)
- dispozitivele ce urmeaza sa fie controlate (LAN, Releu, BJT, FET, IR, BT, etc.)
- senzori
- BUS-ul de distributie de date/curent electric
- amplificatorul audio
- sursa de curent alternativ / circuit de redresare, stabilizare si filtrare

Arhitectura dispozitivelor de control si monitorizare in cazul este urmatoarea:
- Arduino Mega + Ethernet Shield: Master 0, WOP, LIP (prescurtat M0)
- Arduino UNO: Slave 0 -> Master 0 (prescurtat M0/S0)
- Arduino YUN: Master 1, WIP (prescurtat M1)

Dispozitivele conectate pentru a realiza o simulare sunt:
- FET (M0)
- Servo (M0/S0)
- Releu (M1)

Deoarece timpul a de implementare a fost relativ scurt si nu am reusit sa-mi procur materiale in timp util, am folosit pe post de senzori 3 randomizers care vor simula temperatura, luminozitatea si lumina ambientala, toate implementate pe M0.

Software
Implementarea asistentului virtual Amazon Alexa:
Intreaga implementare este realizata pe CC si s-au folosit: Python 2.7 (Tornado Server lib), HTML5, JavaScript (jQuery, webRTC, WebSocket) si Redis-Server (implicit Redis lib pentru Python si Redis-CLI). Mecanismele de functionnare sunt explicate in documentatie, in mare s-a folosit API-ul Amazon Voice Service.

Implementarea Media Center-ului:
Intreaga implementare este realizata pe CC si s-au folosit: Mopidy, PIP, ShairPort si MusicBox. Mecanismele de functionnare sunt explicate in documentatie, in mare s-a folosit MusicBox ca un client pentru Mopidy.

Implementarea sistemului de control:
Aici lucrurile se complica putin si de aceea este nevoie de infrastructura externa (destul de multa). Infrastructura externa este reprezentata de 3 servere (Amazon Skills Kit - Amazon, Node.JS & NoSQL - IBM Bluemix, PHP & Redis-Server & MySQL - carabella.ro), conectiunea intre IWASAMC si servere insa si intre cele 3 servere este HTTPS cu certificate SSL Self-Signed. Schema de interactiune intre hardware si infrastructura externa este atasata ca un screenshot. Fiecare dispozitiv de control si monitorizare are un software care implementeaza .

Update:
    Cateva probleme pe partea de alimentare au cauzat supra alimentarea unor module (M1 si M1S0), consecinta logica este defectarea modulelor. In concluzie codul a fost adaptat astfel incat modulul M0 va indeplini functiile modulelor M1 si M1S0.

Cod sursa:
  - CC (PI - directorul "pi")
  - M0 (Arduino Yun - directorul "yun")

Info: Fiecare director contine un alt fisier "README" cu mai multe informatii referitoare la acea parte din software.

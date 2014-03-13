console
=======
A home server for doing domestic stuff.

This is anticipated to run on something like a Raspberry Pi and provide a website on to a LAN that provides a number of useful features.

At present the following "applications" are implemented:
* Babycam (basically a RPi security MJPG Streamer)
* Evernote to LittlePrinter shopping list gateway 

Applications
------------
Applications are small pieces of code that can provide "panels" on the main UI to do things.

For instance the ShoppingList application provides a panel that will cause a LittlePrinter to print out the latest note in a specified category, reformatting some of the ENML so that <todo/> tags appear as checkboxes. 

This was so I could maintain a shopping list in Evernote, but then easily get a physical version to take shopping.

Applications need to implement in the appinfo.php file the \Console\Applications\IApplication Interface and/or extend the BaseApplication class found in the /lib/AppManager.php file

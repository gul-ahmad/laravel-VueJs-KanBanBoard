
## About Project

- Laravel KanBan application with Drag&Drop of Cards similar to Trello but simplifed

 ## Columns
-  a.Every column has a title.
-  b.The title will be at the top of Column.
-  c.At the top of the column there is a button to delete the Column.
-  d.When column is deleted all cards in it are also deleted.
-  e.We can add new Columns via button.
-  f.New cards to columns can be added via button.
-  g-Cards title etc can be edited by clicking the relevant card

## Cards
-  a-Every card has a title and description
-  b-Every card belong to a colum
-  c-In the column the card only shows title.
-  d-Every card title can be changed/edited by clicking upon it,will open in a Popup Model.
-  e-Cards can be moved/dragged and drop top/bottom in Column and left/right in the Columns.

## More Details
-  a-api are used for all the actions
-  b-Tests are written
-  c-https://github.com/SortableJS/Vue.Draggable used 
-  d-https://www.npmjs.com/package/vue-js-modal used
-  e-Laravel version 9 and Vue 2.5.17
-  f-Webpack Mix used instead of Vite(to tackle depencies issues with vite)



## Note
Lot of things needed to be improved any suggestions are welcome.

## How to use

- Git clone
- composer install
- env settings for db
- php artisan key:generate
- php artisan migrate
- npm install
- npm run dev






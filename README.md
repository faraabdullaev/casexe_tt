Prize Lottery (test task)
=============================


INSTALLATION
------------

**Init**
-
- clone project from repository `git clone https://github.com/faraabdullaev/casexe_tt.git`
- navigate into project `cd casexe_tt`
- in terminal, type: `php init`
- navigate into common configs folder `cd common/config`
- update DB component in `main-local.php`

*to use docker copy:*
```$xslt
'db' => [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=casexe_tt',
    'username' => 'root',
    'password' => 'MY_PASSWORD',
    'charset' => 'utf8',
],
```

**Using Docker**
-

*Build:*
- navigate into `cd docker`
- open a DOCKER terminal 
- `sudo vi /etc/hosts`
- add or replace IP with your docker IP: `127.0.0.1	casexe.tt` and `127.0.0.1 admin.casexe.tt`
- in docker terminal, type: `docker-compose build`
- in docker terminal, type: `docker-compose up -d`

*Run:*
- browse into `cd docker`
- in docker terminal, type: `docker-compose up`
- open your browser and go to: `http://casexe.tt/` or `http://admin.casexe.tt/`

HOW DOES IT WORK
------------
**Preparations**

1. Admin should create a game (status is active) in admin dashboard with following info:
   - 'name': name of game
   - 'conversion_rate': rate for conversion money to bonuses for loyalty card
   - 'money_balance': money limit for current game
   - 'money_from': min limit for random money prize
   - 'money_to': max limit for random money prize
   - 'bonus_from': min limit for random bonus prize
   - 'bonus_to': max limit for random bonus prize
   - 'money_share': probability to get money prize
   - 'gift_share': probability to get gift prize
   - 'bonus_share': probability to get bonus prize

    `money_share` + `gift_share` + `bonus_share` = `max_percent` = 100

2. Admin should add gift prizes in admin dashboard with following info:
   - 'name': name of gift
   - 'game_id': game for which gift is prepared
   - 'count': count of available gifts
3. Admin should manually change statuses of gifts to control 'accepted' > 'sent' > 'processed' flow
4. Admin should run the command to sund bulk of money with N size to Bank API.


DIAGRAMS
------------
**Flow**
- ERD   https://ibb.co/b2skKz
- Process flow   https://ibb.co/fc8QKz

**Prototypes**
- Game Admin Dashboard   https://ibb.co/e2LQme
- Prize Dashboard   https://ibb.co/hTMWRe
- Register   https://ibb.co/dDLM9z
- Login   https://ibb.co/cX8NXK
- Receive prize   https://ibb.co/nxxGsK
- Bonus prize   https://ibb.co/fYONXK
- Gift prize   https://ibb.co/g6Z7zz
- Money prize   https://ibb.co/b2shXK

## Installation process ( Windows )

1.0 Download VirtualBox and install it

https://www.virtualbox.org/

1.1 Download vagrant

https://www.vagrantup.com/

1.2. Install vagrant, write above command in terminal (cmd)

vagrant box add laravel/homestead (add box)

1.2.1 Clone Homestead by running command

git clone https://github.com/laravel/homestead.git ~/Homestead

1.3. Go to destination vagrant folder (C:/Windows/System32/~/Homestead) and init vagrant by executing command

cd ~/Homestead (goes to destination vagrant folder)

git checkout release (checkout latest changes)

bash init.sh (initialize vagrant box) (linux)
init.bat (windows)

1.4. Generate ssh key

ssh-keygen -t rsa -C “your_email@example.com”

1.5. Clone repository to folder where you want your project to appears, example. C:\Users\\<user_name>\Documents\Projects

git clone https://MrCekolek@bitbucket.org/teamstowarzyszenie/stowarzyszenie.git

1.6.Configure Homestead.yaml file in Homestead directory (C:/Windows/System32/~/Homestead)

<user_name> -> it is user that is after C:/Users, for example. C:/Users/Piotr

<to_change> -> it means that only these marked lines need to be changed !!!!, for example <user_name> needs to be replaced by, for example

Piotr. In category "folders:", first line starting from "-map:" needs to be whole replaced by path where project is located!!.

In my case it was C:/Users/Piotr/PhpstormProjects.

ip: "192.168.10.10"

memory: 2048

cpus: 2

provider: virtualbox

authorize: C:/Users/<user_name>/.ssh/id_rsa.pub <to_change>

keys:

    - C:/Users/<user_name>/.ssh/id_rsa <to_change>

folders:

    - map: C:/Users/<user_name>/PhpstormProjects <to_change> (whole line needs to be changed, there should be path to project !! not only <user_name>)
      to: /home/vagrant/code

sites:

    - map: stowarzyszenie.test
      to: /home/vagrant/code/stowarzyszenie/public

databases:

    - stowarzyszenie

features:

    - mariadb: false
	
    - ohmyzsh: false
	
    - webdriver: false
	

1.7. Configure hosts file (C:/Windows/System32/drivers/etc/hosts), add following line at the end of file

192.168.10.10 stowarzyszenie.test

1.8. To init vagrant machine type (C:/Windows/System32/~/Homestead)

vagrant up

1.9. To connect with vagrant machine type (C:/Windows/System32/~/Homestead)

vagrant ssh

1.10. Generate artisan key, after executing above command, "vagrant ssh", type

cd code/stowarzyszenie

!! Important !!
---
When there is no folders code or stowarzyszenie, that means some of the above steps weren't done correctly !!!!!. Try again.

But if we have them, execute these commands.

cd code/stowarzyszenie

copy file .env.example to file .env (if file .env doesn't exists in project, feel free to create it and copy text from .env.example file to newly created .env file)

composer install (install all required packages)

php artisan key:generate (it generates artisan key)

php artisan jwt:secret (it generated key for token based authorization)

php artisan migrate:fresh --seed (it created table in database and initializes them with sample data)

php artisan queue:work (and it runs continiously, it means when you want your website to run correctly, you must

run this command and don't stop it !!. It is used to send emails, so user send email and emails are sending in background,

user can use site and meanwhile in background server is sending emails.)

!! In another terminal window, not on vagrant, can be simple terminal, when server is on, we must enable front site of our page to work, so !!
---

Type these commands

Go to path where project is located, for example in my case it is: C:/Users/Piotr/Phpstormprojects/stowarzyszenie

Go to front folder, so type:

cd front

when you are in path C:/Users/Piotr/Phpstormprojects/stowarzyszenie/front, execute these commands:

npm install (install front packages, run it only once)

ng serve (it runs continously, same as php artisan queue:work, so don't stop it, when you get no errors and there

is message that server is running at localhost:4200, click on it or open web browser and type localhost:4200)

If everything went alright website should appear and everything should work fine.
---


---

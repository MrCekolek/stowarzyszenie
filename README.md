## Installation process ( Windows )

1.1 Download vagrant

https://www.vagrantup.com/

1.2. Install vagrant

vagrant box add laravel/homestead

1.3. Go to destination vagrant folder (C:/Windows/System32/~/Homestead) and init vagrant by executing command

bash init.sh

1.4. Generate ssh key

ssh-keygen -t rsa -C “your_email@example.com”

1.5. Clone repository to C:/Users/<user_name>/PhpstormProjects/

git clone https://MrCekolek@bitbucket.org/teamstowarzyszenie/stowarzyszenie.git

1.6.Configure Homestead.yaml file in Homestead directory

ip: "192.168.10.10"

memory: 2048

cpus: 2

provider: virtualbox

authorize: C:/Users/zalew/.ssh/id_rsa.pub

keys:

    - C:/Users/zalew/.ssh/id_rsa

folders:

    - map: C:/Users/zalew/PhpstormProjects
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
	
	
1.7. Load changes

vagrant reload --provision

1.8. Configure hosts file (C:/Windows/System32/drivers/etc/), add following line at the end of file

192.168.10.10 stowarzyszenie.test

---
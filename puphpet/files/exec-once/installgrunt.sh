gem install compass

git clone https://github.com/joyent/node.git
cd node
./configure
make
make install

cd /vagrant
npm install -g bower
npm install -g grunt-cli
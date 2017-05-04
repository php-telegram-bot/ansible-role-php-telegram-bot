role = File.basename(File.expand_path(File.dirname(__FILE__)))

boxes = [
  {
    :name => "ubuntu-1204",
    :box => "opscode-ubuntu-12.04",
    :url => "http://opscode-vm-bento.s3.amazonaws.com/vagrant/virtualbox/opscode_ubuntu-12.04_chef-provisionerless.box",
  },
  {
    :name => "ubuntu-1404",
    :box => "opscode-ubuntu-14.04",
    :url => "http://opscode-vm-bento.s3.amazonaws.com/vagrant/virtualbox/opscode_ubuntu-14.04_chef-provisionerless.box",
  },
  {
    :name => "ubuntu-1604",
    :box => "opscode-ubuntu-16.04",
    :url => "http://opscode-vm-bento.s3.amazonaws.com/vagrant/virtualbox/opscode_ubuntu-16.04_chef-provisionerless.box",
  },
  {
    :name => "debian-711",
    :box => "opscode-debian-7.11",
    :url => "http://opscode-vm-bento.s3.amazonaws.com/vagrant/virtualbox/opscode_debian-7.11_chef-provisionerless.box",
  },
  {
    :name => "debian-85",
    :box => "opscode-debian-8.5",
    :url => "http://opscode-vm-bento.s3.amazonaws.com/vagrant/virtualbox/opscode_debian-8.5_chef-provisionerless.box",
  },
]

Vagrant.configure("2") do |config|
  boxes.each do |box|
    config.vm.define box[:name] do |vms|
      vms.vm.box = box[:box]
      vms.vm.box_url = box[:url]
      vms.vm.hostname = "ansible-#{role}-#{box[:name]}"

      vms.vm.provider "virtualbox" do |v|
        v.customize ["modifyvm", :id, "--cpuexecutioncap", "50"]
        v.customize ["modifyvm", :id, "--memory", "256"]
      end

      vms.vm.provision :ansible do |ansible|
        ansible.playbook = "tests/vagrant.yml"
        ansible.verbose = "vv"
      end
    end
  end
end

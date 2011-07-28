set :domain,    "rowndly.com" 
set :user,      "rowndly" 
set :password,  "corner"
 
# Your git repository
set :repository, "git@git.assembla.com:rowndly.git" 
 
server "#{domain}", :web, :primary => true 
 
set :deploy_via, :copy
set :copy_exclude, [".git", ".DS_Store"] 
set :scm, :git
set :branch, "master" 
# set this path to be correct on your server
set :deploy_to, "/httpdocs"
set :use_sudo, false 
set :keep_releases, 5 
set :git_shallow_clone, 1 
 
ssh_options[:paranoid] = false 
 
# this tells capistrano what to do when you deploy
namespace :deploy do 
 
  desc <<-DESC
  A macro-task that updates the code and fixes the symlink. 
  DESC
  task :default do 
    transaction do 
      update_code
      make_writeable
      symlink
      symlink_config
    end
  end
 
  task :update_code, :except => { :no_release => true } do 
    on_rollback { run "rm -rf #{release_path}; true" } 
    strategy.deploy! 
  end
 
  # Link up your specific database config file under your shared path
  task :symlink_config, :except => { :no_release => true } do
    run "ln -nsf #{shared_path}/application/config/database.php #{current_release}/application/config"
  end
 
  task :after_deploy do
    cleanup
  end
  
  # If using caching and if you want to see the logs - make those dirs writeable!
  task :make_writeable, :except => { :no_release => true } do
    run "chmod -R 777 #{current_release}/system/cache"
    run "chmod -R 777 #{current_release}/system/logs"
  end
  
end
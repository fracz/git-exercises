1. Clone the repo

    git clone https://github.com/fracz/git-exercises.git
	cd git-exercises

2. Adjust the environment variables

	cd docker
    cp env.example .env
	
	Change the values of those variables according to your domain specifics :
	
	DOMAIN_NAME=<Your domain name> # used in the cloning URL
	SITE_ADMIN_NAME=<Your admin name> # used as the committer name for given commits
	SITE_ADMIN_EMAIL=<Your admin email> # used as the committer email for given commits

	Change the value of this variable if you wish to use a different repo as a source of exercises :
	
	GIT_REPO=<URL to a repo of questions>

3. Run with docker-compose

    docker-compose up -d
	
4. The web app should be available at https://$DOMAIN_NAME/

5. The exercise repo should be available at git://$DOMAIN_NAME/git/exercises.git


def repoName = 'php' 
def buildName = "php-app"

properties([pipelineTriggers([githubPush()])])
pipeline {

    agent {
        node {
            label 'swarm-ci'
        }
    }
}

stages {

        stage('Checkout SCM') {
            steps {
                git branch:"**",url: "https://github.com/ek2020/php-jenkins.git"
                script {
                    branch = "${GIT_BRANCH}".split('/')[0]
                }
                echo "CHECK OUT BRANCH:${branch}"
            }
        }
//security check to analysis any credential present in source code
         stage('Check-git-Secrets')
        { 
            steps {
            sh 're trufflehog||true'
            sh 'docker run gesellix/trufflehog --json https://github.com/ek2020/php-jenkins.git > trufflehog'
            sh 'cat  trufflehog'
            }
        }

        stage('Build') {
            steps {
                script {
                    if (branch == 'master' || branch == 'develop'){
                        sh "docker rmi ${buildName} || true"
                        sh "docker build -t ${buildName} apache/"
                    } else if (branch.contains('feature')) {
                        echo "SORRY IT IS FEATURE BRANCH"
                    }
                }
            }
        }

        stage('Deploy') {
            steps {

                script {
                    if (branch == 'master'){
                        REGISTRY="853973692277.dkr.ecr.us-east-1.amazonaws.com"
                        ECR_REPO="jenkins"
                        sh """
                            docker tag ${buildName} ${REGISTRY}/${ECR_REPO}:1.${BUILD_NUMBER}
                            docker push ${REGISTRY}/${ECR_REPO}
                        """
                    } 
                }
            }
        }

}
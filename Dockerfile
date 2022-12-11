FROM webdevops/php-dev:7.4-alpine

# Set working directory
WORKDIR /var/www

ENV WEB_DOCUMENT_ROOT=/var/www/public

# Phalcon version setting
ARG PSR_VERSION=1.0.0
ARG PHALCON_VERSION=4.0.5
ARG PHALCON_EXT_PATH=php7/64bits

# Install dependencies
RUN set -xe && \
   # Install PSR
   curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
   tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
   # Install Phalcon
   curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
   tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
   docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) \
       ${PWD}/php-psr-${PSR_VERSION} \
       ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} \
   && \
   # Remove tmp file
   rm -r \
       ${PWD}/v${PSR_VERSION}.tar.gz \
       ${PWD}/php-psr-${PSR_VERSION} \
       ${PWD}/v${PHALCON_VERSION}.tar.gz \
       ${PWD}/cphalcon-${PHALCON_VERSION} \
   && \
   php -m

# Copy existing application directory contents
COPY . /var/www

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Expose port 9000
EXPOSE 9000
